"""

    queries.py

    Written by Dane Rainbird (drai0001@student.monash.edu)
    Last edited 12/08/2021

    Performs business / data manipulation on results from
    a given query to the PuppetDB

"""

# Imports
import math


def schoolbox_totalusers(result):
    """
    Generates information pertaining to the "schoolbox_totalusers" fact
    :param result: response from the PuppetDB server query
    :return: a dictionary containing total users across the entire fleet, and
    statistics on the range of users
    """
    totalUserFleetCount = 0
    totalUsers = {}
    for returnedServers in result:
        for server in returnedServers:
            # Ensure only using production servers
            if '.prd.' in server['certname'] or '.live.' in server['certname']:
                # Increase the total user count
                totalUserFleetCount = totalUserFleetCount + sum(list(server['value'].values()))

                # Create the totalUsersArray
                tmp = math.floor(sum(list(server['value'].values())) / 1000)
                if not str(tmp) in totalUsers.keys():
                    totalUsers[str(tmp)] = 0

                totalUsers[str(tmp)] = totalUsers[str(tmp)] + 1

    return {
        'totalUsersFleetCount': totalUserFleetCount,
        'totalUsers': totalUsers
    }
