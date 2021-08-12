"""

    cronjob.py

    Written by Dane Rainbird (drai0001@student.monash.edu)
    Last edited 12/08/2021

    Pulls data from the Schoolbox PuppetDB Servers and produces blobs
    that are stored in a local MySQL DB for later loading

"""
# Imports
import json
import os
import urllib.parse
import requests
from dotenv import load_dotenv
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
        'schoolbox_users_student': queries.schoolbox_users_student,
        'schoolbox_users_staff': queries.schoolbox_users_staff,
        'schoolbox_users_parent': queries.schoolbox_users_parent,
        'schoolbox_totalcampus': queries.schoolbox_totalcampus,
        'virtual': queries.virtual
    }
    function = querySwitcher.get(query, "Unknown query type")
    if type(function) is str:
        return "Unknown query type: \"" + query + "\". Please check inputs and try again."

    return function(executeRequest(query))


def main():
    # Load environment variables
    load_dotenv()

    # Ensure that a facts name file exists
    if not (os.path.isfile(keysFilePath)):
        exit("Please ensure a the keys file (named factnames.json) is within the working directory.")

    # Set global variable of fact key names
    keys = getFactKeysFromJson(keysFilePath)
    for key in keys:
        factKeys.append(key.strip())

    # Get data from each fact query
    for fact in factKeys:
        print(performQuery(fact))


def __init__():
    """
    init function
    """
    main()


# Run the main function
main()
