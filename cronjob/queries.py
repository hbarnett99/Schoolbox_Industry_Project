"""

    queries.py

    Written by Dane Rainbird (drai0001@student.monash.edu)
    Last edited 12/08/2021

    Performs business / data manipulation on results from
    a given query to the PuppetDB

"""

# Imports
import math
from datetime import date

# Global Variables
siteType = {}


def schoolbox_config_site_type(result):
    for returnedServers in result:
        for server in returnedServers:
            for item in server['value'].items():
                siteType[item[0]] = item[1]

    return siteType


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


def processorcount(result):
    processorCounts = {}
    total = 0
    for returnedServers in result:
        for server in returnedServers:
            if not server['value'] in processorCounts.keys():
                processorCounts[server['value']] = {'count': 1, 'percent': 0}
            else:
                processorCounts[server['value']]['count'] = processorCounts[server['value']]['count'] + 1
            total = total + 1

    # Get percentage of total install for each server type
    for coreCount in processorCounts:
        count = processorCounts.get(coreCount).get('count')
        percent = round((count / total) * 100, 2)
        processorCounts.get(coreCount)['percent'] = percent

    return processorCounts


def memorysize(result):
    memoryArray = {}
    total = 0
    for returnedServers in result:
        for server in returnedServers:
            if 'MiB' in server['value'] or 'MB' in server['value']:
                server['value'] = math.ceil(int(float(server["value"].split()[0]) / 1024)) + 1
            else:
                server['value'] = math.ceil((int(float(server['value'].split()[0])))) + 1

            if not server['value'] in memoryArray.keys():
                memoryArray[server['value']] = {'count': 1, 'percent': 0}
            else:
                memoryArray[server['value']]['count'] = memoryArray[server['value']]['count'] + 1
            total = total + 1

    # Get percentage of total install for each server type
    for memSize in memoryArray:
        count = memoryArray.get(memSize).get('count')
        percent = round((count / total) * 100, 2)
        memoryArray.get(memSize)['percent'] = percent

    return memoryArray


def schoolbox_config_date_timezone(result):
    timezoneCount = {}
    total = 0
    for returnedServers in result:
        for server in returnedServers:
            # Only use production servers
            if '.prd.' in server['certname'] or '.live.' in server['certname']:
                # Only get the value from the returned dict (not sure why this one returns a nested dict?)
                server['value'] = list(server['value'].values())[0]
                if not server['value'] in timezoneCount.keys():
                    timezoneCount[server['value']] = {'count': 1, 'percent': 0}
                else:
                    timezoneCount[server['value']]['count'] = timezoneCount[server['value']]['count'] + 1
                total = total + 1

    # Get percentage of total install for each server type
    for timezone in timezoneCount:
        count = timezoneCount.get(timezone).get('count')
        percent = round((count / total) * 100, 2)
        timezoneCount.get(timezone)['percent'] = percent

    return timezoneCount


def schoolbox_config_external_type(result):
    externalDBTypes = {}
    total = 0
    for returnedServers in result:
        for server in returnedServers:
            # Only use production servers
            if '.prd.' in server['certname'] or '.live.' in server['certname']:
                server['value'] = list(server['value'].values())[0]
                if not server['value'] in externalDBTypes.keys():
                    externalDBTypes[server['value']] = {'count': 1, 'percent': 0}
                else:
                    externalDBTypes[server['value']]['count'] = externalDBTypes[server['value']]['count'] + 1
                total = total + 1

    # Get percentage of total install for each server type
    for dbType in externalDBTypes:
        count = externalDBTypes.get(dbType).get('count')
        percent = round((count / total) * 100, 2)
        externalDBTypes.get(dbType)['percent'] = percent

    return externalDBTypes


def schoolbox_first_file_upload_year(result):
    firstFileUpload = {}
    total = 0
    for returnedServers in result:
        for server in returnedServers:
            # Only use 'live' servers
            if '.live.' in server['certname']:
                # Remove excess quotation marks from string
                server['value'] = server['value'].replace('\"', '')

                # Replace NULLs with current year
                if server['value'] == 'NULL':
                    server['value'] = str(date.today().year)

                if not server['value'] in firstFileUpload.keys():
                    firstFileUpload[server['value']] = {'count': 1, 'percent': 0}
                else:
                    firstFileUpload[server['value']]['count'] = firstFileUpload[server['value']]['count'] + 1
                total = total + 1

    # Get percentage of total install for each server type
    for fileUploadDate in firstFileUpload:
        count = firstFileUpload.get(fileUploadDate).get('count')
        percent = round((count / total) * 100, 2)
        firstFileUpload.get(fileUploadDate)['percent'] = percent

    return firstFileUpload


def mysql_extra_version(result):
    mysqlTypes = {}
    total = 0
    for returnedServers in result:
        for server in returnedServers:
            # Only use production servers
            if not server['value'] in mysqlTypes.keys():
                mysqlTypes[server['value']] = {'count': 1, 'percent': 0}
            else:
                mysqlTypes[server['value']]['count'] = mysqlTypes[server['value']]['count'] + 1
            total = total + 1

    # Get percentage of total install for each server type
    for sqlType in mysqlTypes:
        count = mysqlTypes.get(sqlType).get('count')
        percent = round((count / total) * 100, 2)
        mysqlTypes.get(sqlType)['percent'] = percent

    return mysqlTypes


def php_cli_version(result):
    phpVersions = {}
    total = 0
    for returnedServers in result:
        for server in returnedServers:
            if not server['value'] in phpVersions.keys():
                phpVersions[server['value']] = {'count': 1, 'percent': 0}
            else:
                phpVersions[server['value']]['count'] = phpVersions[server['value']]['count'] + 1
            total = total + 1

    # Get percentage of total install for each server type
    for php in phpVersions:
        count = phpVersions.get(php).get('count')
        percent = round((count / total) * 100, 2)
        phpVersions.get(php)['percent'] = percent

    return phpVersions


def kernelrelease(result):
    kernelTypes = {}
    total = 0
    for returnedServers in result:
        for server in returnedServers:
            if not server['value'] in kernelTypes.keys():
                kernelTypes[server['value']] = {'count': 1, 'percent': 0}
            else:
                kernelTypes[server['value']]['count'] = kernelTypes[server['value']]['count'] + 1
            total = total + 1

    # Get percentage of total install for each server type
    for kernelType in kernelTypes:
        count = kernelTypes.get(kernelType).get('count')
        percent = round((count / total) * 100, 2)
        kernelTypes.get(kernelType)['percent'] = percent

    return kernelTypes


def kernelmajversion(result):
    kernelVersions = {}
    total = 0
    for returnedServers in result:
        for server in returnedServers:
            if not server['value'] in kernelVersions.keys():
                kernelVersions[server['value']] = {'count': 1, 'percent': 0}
            else:
                kernelVersions[server['value']]['count'] = kernelVersions[server['value']]['count'] + 1
            total = total + 1

    # Get percentage of total install for each server type
    for kernelType in kernelVersions:
        count = kernelVersions.get(kernelType).get('count')
        percent = round((count / total) * 100, 2)
        kernelVersions.get(kernelType)['percent'] = percent

    return kernelVersions


def lsbdistdescription(result):
    linuxVersions = {}
    total = 0
    for returnedServers in result:
        for server in returnedServers:
            if not server['value'] in linuxVersions.keys():
                linuxVersions[server['value']] = {'count': 1, 'percent': 0}
            else:
                linuxVersions[server['value']]['count'] = linuxVersions[server['value']]['count'] + 1
            total = total + 1

    # Get percentage of total install for each server type
    for linuxVersion in linuxVersions:
        count = linuxVersions.get(linuxVersion).get('count')
        percent = round((count / total) * 100, 2)
        linuxVersions.get(linuxVersion)['percent'] = percent

    return linuxVersions


def schoolbox_config_site_version(result):
    stagingServerVersions = {}
    productionServerVersions = {}
    stagingTotal = 0
    productionTotal = 0

    for returnedServers in result:
        for server in returnedServers:
            # Get all dev / staging servers
            if siteType.get(list(server['value'])[0]) == 'dev':
                for item in server['value'].items():
                    versionNum = item[1]
                    if not versionNum in stagingServerVersions.keys():
                        stagingServerVersions[versionNum] = {'count': 1, 'percent': 0}
                    else:
                        stagingServerVersions[versionNum]['count'] = stagingServerVersions[versionNum]['count'] + 1

                    stagingTotal = stagingTotal + 1

            # Get all dev / staging servers
            if siteType.get(list(server['value'])[0]) == 'prod':
                for item in server['value'].items():
                    versionNum = item[1]
                    if not versionNum in productionServerVersions.keys():
                        productionServerVersions[versionNum] = {'count': 1, 'percent': 0}
                    else:
                        productionServerVersions[versionNum]['count'] = productionServerVersions[versionNum][
                                                                         'count'] + 1
                    productionTotal = productionTotal + 1

    # Get percentages for staging servers
    for stagingServerVersion in stagingServerVersions:
        count = stagingServerVersions.get(stagingServerVersion).get('count')
        percent = round((count / stagingTotal) * 100, 2)
        stagingServerVersions.get(stagingServerVersion)['percent'] = percent

    # Get percentages for production servers
    for productionServerVersion in productionServerVersions:
        count = productionServerVersions.get(productionServerVersion).get('count')
        percent = round((count / productionTotal) * 100, 2)
        productionServerVersions.get(productionServerVersion)['percent'] = percent

    return {
        'stagingServers': stagingServerVersions,
        'productionServers': productionServerVersions
    }


def schoolbox_package_version(result):
    productionPackageVersions = {}
    developmentPackageVersions = {}
    productionTotal = 0
    developmentTotal = 0
    for returnedServers in result:
        for server in returnedServers:
            # Get production server statistics
            if server['environment'] == 'production':
                if not server['value'] in productionPackageVersions.keys():
                    productionPackageVersions[server['value']] = {'count': 1, 'percent': 0}
                else:
                    productionPackageVersions[server['value']]['count'] = productionPackageVersions[server['value']]['count'] + 1
                productionTotal = productionTotal + 1

            # Get development server statistics
            if server['environment'] == 'staging':
                if not server['value'] in developmentPackageVersions.keys():
                    developmentPackageVersions[server['value']] = {'count': 1, 'percent': 0}
                else:
                    developmentPackageVersions[server['value']]['count'] = developmentPackageVersions[server['value']]['count'] + 1
                developmentTotal = developmentTotal + 1

    # Get percentages for production server statistics
    for packageVersion in productionPackageVersions:
        count = productionPackageVersions.get(packageVersion).get('count')
        percent = round((count / productionTotal) * 100, 2)
        productionPackageVersions.get(packageVersion)['percent'] = percent

    # Get percentages for development server statistics
    for packageVersion in developmentPackageVersions:
        count = developmentPackageVersions.get(packageVersion).get('count')
        percent = round((count / productionTotal) * 100, 2)
        developmentPackageVersions.get(packageVersion)['percent'] = percent

    return {
        'productionPackageVersions': productionPackageVersions,
        'developmentPackageVersions': developmentPackageVersions
    }


def schoolboxdev_package_version(result):
    productionPackageVersions = {}
    developmentPackageVersions = {}
    productionTotal = 0
    developmentTotal = 0
    for returnedServers in result:
        for server in returnedServers:
            # Get production server statistics
            if server['environment'] == 'production':
                if not server['value'] in productionPackageVersions.keys():
                    productionPackageVersions[server['value']] = {'count': 1, 'percent': 0}
                else:
                    productionPackageVersions[server['value']]['count'] = productionPackageVersions[server['value']]['count'] + 1
                productionTotal = productionTotal + 1

            # Get development server statistics
            if server['environment'] == 'staging':
                if not server['value'] in developmentPackageVersions.keys():
                    developmentPackageVersions[server['value']] = {'count': 1, 'percent': 0}
                else:
                    developmentPackageVersions[server['value']]['count'] = developmentPackageVersions[server['value']]['count'] + 1
                developmentTotal = developmentTotal + 1

    # Get percentages for production server statistics
    for packageVersion in productionPackageVersions:
        count = productionPackageVersions.get(packageVersion).get('count')
        percent = round((count / productionTotal) * 100, 2)
        productionPackageVersions.get(packageVersion)['percent'] = percent

    # Get percentages for development server statistics
    for packageVersion in developmentPackageVersions:
        count = developmentPackageVersions.get(packageVersion).get('count')
        percent = round((count / productionTotal) * 100, 2)
        developmentPackageVersions.get(packageVersion)['percent'] = percent

    return {
        'productionPackageVersions': productionPackageVersions,
        'developmentPackageVersions': developmentPackageVersions
    }
