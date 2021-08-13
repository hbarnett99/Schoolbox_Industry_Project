"""

    cronjob.py

    Written by Dane Rainbird (drai0001@student.monash.edu)
    Last edited 12/08/2021

    Pulls data from the Schoolbox PuppetDB Servers and produces blobs
    that are stored in a local MySQL DB for later loading

"""
# Imports
import datetime
import json
import os
import urllib.parse
import requests
from dotenv import load_dotenv
import pymysql.cursors
import queries

# Global Variables
keysFilePath = os.path.dirname(os.path.abspath(__file__)) + '\\factnames.json'
puppetDbServers = ['https://puppetdb.stg.1.schoolbox.com.au', 'https://puppetdb.prd.1.schoolbox.com.au']
factKeys = []


def getFactKeysFromJson(filename):
    """
    Reads the keys from a JSON file

    :param filename: the JSON file name (must include .json) to be read
    :return: dict_keys of all keys within the JSON file provided
    """
    file = open(filename, 'r')
    jsonTemp = json.load(file)
    file.close()

    return jsonTemp.keys()


def executeRequest(query):
    """
    Executes a request to the PuppetDB servers for a given fact key
    :param query: a fact name stored within the PuppetDB
    :return: JSON object with relevant data if successful, otherwise 0
    """
    # Ensure that the fact is a known value
    if query not in factKeys:
        return 0

    # Format query string correctly
    formattedQuery = '["=",+"name",+"' + query + '"]'

    # Ensure that URL is encoded in the specific way that the PuppetDB instance is expecting
    queryEncoded = urllib.parse.urlencode({'query': formattedQuery}, safe='+')
    queryEncoded = queryEncoded.replace("query=", '')

    # PuppetDB requires specific JSON accept headers to function
    headers = {'Accept': 'application/json', 'Authorization': 'Basic ' + os.getenv('PROXY_COMBINED_AUTH')}

    # Query each PuppetDB server for results
    results = []
    for server in puppetDbServers:
        results.append(
            json.loads(requests.get(server + '/pdb/query/v4/facts?query=' + queryEncoded, headers=headers).text))

    return results


def performQuery(query):
    """
    Performs a given query and it's associated business logic, and returns the value
    :param query: a fact name stored within the PuppetDB
    :return: dictionary containing results if successful, otherwise string indicating error
    """
    querySwitcher = {
        'schoolbox_totalusers': queries.schoolbox_totalusers,
        'schoolbox_config_site_type': queries.schoolbox_config_site_type,
        'schoolbox_users_student': queries.schoolbox_users_student,
        'schoolbox_users_staff': queries.schoolbox_users_staff,
        'schoolbox_users_parent': queries.schoolbox_users_parent,
        'schoolbox_totalcampus': queries.schoolbox_totalcampus,
        'virtual': queries.virtual,
        'processorcount': queries.processorcount,
        'memorysize': queries.memorysize,
        'schoolbox_config_date_timezone': queries.schoolbox_config_date_timezone,
        'schoolbox_config_external_type': queries.schoolbox_config_external_type,
        'schoolbox_first_file_upload_year': queries.schoolbox_first_file_upload_year,
        'mysql_extra_version': queries.mysql_extra_version,
        'php_cli_version': queries.php_cli_version,
        'kernelrelease': queries.kernelrelease,
        'kernelmajversion': queries.kernelmajversion,
        'lsbdistdescription': queries.lsbdistdescription,
        'schoolbox_config_site_version': queries.schoolbox_config_site_version,
        'schoolbox_package_version': queries.schoolbox_package_version,
        'schoolboxdev_package_version': queries.schoolboxdev_package_version
    }
    function = querySwitcher.get(query, "Unknown query type")
    if type(function) is str:
        return "Unknown query type: \"" + query + "\". Please check inputs and try again."

    return function(executeRequest(query))


def insertIntoDb(results):
    """
    Inserts the data obtained from querying the PuppetDB and performing business analysis and
    inserts them into a MySQL DB
    :param results: an array containing all the results taken from the previous queries
    """
    connection = pymysql.connect(host='localhost',
                                 user='root',
                                 password='',
                                 database='u21s1026_schoolbox',
                                 charset='utf8mb4',
                                 cursorclass=pymysql.cursors.DictCursor)

    currentTime = datetime.datetime.now()

    with connection:
        with connection.cursor() as cursor:
            sql = "INSERT INTO `historical_facts`(`timestamp`, `schoolbox_totalusers`, `schoolbox_config_site_type`, " \
                  "`schoolbox_users_student`, `schoolbox_users_staff`, `schoolbox_users_parent`, " \
                  "`schoolbox_totalcampus`, `schoolbox_package_version`, `schoolboxdev_package_version`, " \
                  "`schoolbox_config_site_version`, `virtual`, `lsbdistdescription`, `kernelmajversion`," \
                  "`kernelrelease`, `php_cli_version`, `mysql_extra_version`, `processorcount`,`memorysize`, " \
                  "`schoolbox_config_date_timezone`, `schoolbox_config_external_type`," \
                  "`schoolbox_first_file_upload_year`) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s," \
                  "%s,%s,%s) "
            cursor.execute(sql, (currentTime, json.dumps(results.get('schoolbox_totalusers')), json.dumps(results.get('schoolbox_config_site_type')), json.dumps(results.get('schoolbox_users_student')), json.dumps(results.get('schoolbox_users_staff')), json.dumps(results.get('schoolbox_users_parent')), json.dumps(results.get('schoolbox_totalcampus')), json.dumps(results.get('schoolbox_package_version')), json.dumps(results.get('schoolboxdev_package_version')), json.dumps(results.get('schoolbox_config_site_version')), json.dumps(results.get('virtual')), json.dumps(results.get('lsbdistdescription')), json.dumps(results.get('kernelmajversion')), json.dumps(results.get('kernelrelease')), json.dumps(results.get('php_cli_version')), json.dumps(results.get('mysql_extra_version')), json.dumps(results.get('processorcount')), json.dumps(results.get('memorysize')), json.dumps(results.get('schoolbox_config_date_timezone')), json.dumps(results.get('schoolbox_config_external_type')), json.dumps(results.get('schoolbox_first_file_upload_year'))))

        connection.commit()


def main():
    """
    Main function
    """
    # Load environment variables
    load_dotenv()

    print("Beginning cronjob at " + str(datetime.datetime.now()))

    # Ensure that a facts name file exists
    if not (os.path.isfile(keysFilePath)):
        exit("Please ensure a the keys file (named factnames.json) is within the working directory.")

    # Set global variable of fact key names
    keys = getFactKeysFromJson(keysFilePath)
    for key in keys:
        factKeys.append(key.strip())

    print("Obtained all facts from file.")

    # Get data from each fact query
    results = {}
    for fact in factKeys:
        print("Executing query for fact '" + fact + "'. Please wait.")
        results[fact] = performQuery(fact)

    print("All fact data gathered successfully.\n")
    insertIntoDb(results)


def __init__():
    """
    init function
    """
    main()


# Run the main function
main()
