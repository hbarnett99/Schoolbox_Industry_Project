"""

    cronjob.py

    Written by Dane Rainbird (drai0001@student.monash.edu)
    Last edited 11/08/2021

    Pulls data from the Schoolbox PuppetDB Servers and produces blobs
    that are stored in a local MySQL DB for later loading

"""
# Imports
import json
import os
import urllib.parse
import requests

# Global Variables
keysFilePath = os.path.dirname(os.path.abspath(__file__)) + '\\factnames.json'
puppetDbServers = ['http://puppet.alaress.com.au:8080', 'http://puppetstage.alaress.com.au:8080']
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
    if query not in factKeys:
        return 0

    formattedQuery = '["=",+"name",+"' + query + '"]'

    queryEncoded = urllib.parse.urlencode({'query': formattedQuery}, safe='+')
    queryEncoded = queryEncoded.replace("query=", '')

    headers = {'Accept': 'application/json'}
    request = requests.get(puppetDbServers[1] + '/pdb/query/v4/facts?query=' + queryEncoded, headers=headers)
    return json.loads(request.text)


def main():
    if not (os.path.isfile(keysFilePath)):
        exit("Please ensure a the keys file (named factnames.json) is within the working directory.")

    keys = getFactKeysFromJson(keysFilePath)
    for key in keys:
        factKeys.append(key.strip())

    print(executeRequest('virtual'))


def __init__():
    """
    init function
    """
    main()


main()
