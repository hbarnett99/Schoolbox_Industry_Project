"""

    queries.py

    Written by Dane Rainbird (drai0001@student.monash.edu)
    Last edited 12/08/2021

    Performs business / data manipulation on results from
    a given query to the PuppetDB

"""

# Imports
import math
import pprint


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


def schoolbox_users_student(result):
    totalStudentCount = 0
    for returnedServers in result:
        for server in returnedServers:
            # Ensure only using production servers
            if '.prd.' in server['certname'] or '.live.' in server['certname']:
                # Increase the total user count
                totalStudentCount = totalStudentCount + sum(list(map(int, server['value'].values())))

    return {
        'totalStudentCount': totalStudentCount
    }


def schoolbox_users_staff(result):
    totalStaffCount = 0
    for returnedServers in result:
        for server in returnedServers:
            # Ensure only using production servers
            if '.prd.' in server['certname'] or '.live.' in server['certname']:
                # Increase the total user count
                totalStaffCount = totalStaffCount + sum(list(map(int, server['value'].values())))

    return {
        'totalStaffCount': totalStaffCount
    }


def schoolbox_users_parent(result):
    totalParentCount = 0
    for returnedServers in result:
        for server in returnedServers:
            # Ensure only using production servers
            if '.prd.' in server['certname'] or '.live.' in server['certname']:
                # Increase the total user count
                totalParentCount = totalParentCount + sum(list(map(int, server['value'].values())))

    return {
        'totalParentCount': totalParentCount
    }


def schoolbox_totalcampus(result):
    totalCampus = 0
    for returnedServers in result:
        for server in returnedServers:
            # Ensure only using production servers
            if '.prd.' in server['certname'] or '.live.' in server['certname']:
                # Increase the total user count
                totalCampus = totalCampus + sum(list(map(int, server['value'].values())))

    return {
        'totalCampus': totalCampus
    }


def virtual(result):
    serverTypes = ['.prd.', '.live.', '.dev.', '.stg.', '.dr.']
    virtualServerType = {}
    total = 0
    for returnedServers in result:
        for server in returnedServers:
            # Only used named dev and prod servers
            if any(x in server['certname'] for x in serverTypes):
                if not server['value'] in virtualServerType.keys():
                    virtualServerType[server['value']] = {'count': 1, 'percent': 0}
                else:
                    virtualServerType[server['value']]['count'] = virtualServerType[server['value']]['count'] + 1
                total = total + 1

    # Get percentage of total install for each server type
    for virtualType in virtualServerType:
        count = virtualServerType.get(virtualType).get('count')
        percent = round((count / total) * 100, 2)
        virtualServerType.get(virtualType)['percent'] = percent

    return virtualServerType
