<?php

/*
 * This file is part of PhpZabbixApi.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @copyright The MIT License (MIT)
 * @author confirm IT solutions GmbH, Rathausstrase 14, CH-6340 Baar
 */

namespace ZabbixSdkBuilder\Tests;

use PHPUnit\Framework\TestCase;
use ZabbixApi\ZabbixApi;
use ZabbixApi\ZabbixApiInterface;

/**
 * @author Javier Spagnoletti <phansys@gmail.com>
 */
final class BuildTest extends TestCase
{
    public function testZabbixClass(): void
    {
        $this->assertTrue(class_exists(ZabbixApi::class));
        $this->assertTrue(is_subclass_of(ZabbixApi::class, ZabbixApiInterface::class));
    }

    public function testZabbixApiSymbolsCount(): void
    {
        $zabbix = new ZabbixApi('https://localhost/json_rpc.php', 'zabbix', 'very_secret');
        $ro = new \ReflectionObject($zabbix);

        $this->assertGreaterThanOrEqual(668, count($ro->getConstants()));
    }

    /**
     * @dataProvider provideMethodNames
     */
    public function testZabbixApiMethods(string $methodName): void
    {
        $this->assertTrue(method_exists(ZabbixApi::class, $methodName));
    }

    public function provideMethodNames(): iterable
    {
        yield ['apiTableName'];
        yield ['apiPk'];
        yield ['apiPkOption'];
        yield ['actionGet'];
        yield ['actionCreate'];
        yield ['actionUpdate'];
        yield ['actionDelete'];
        yield ['actionValidateOperationsIntegrity'];
        yield ['actionValidateOperationConditions'];
        yield ['actionTableName'];
        yield ['actionPk'];
        yield ['actionPkOption'];
        yield ['alertGet'];
        yield ['alertTableName'];
        yield ['alertPk'];
        yield ['alertPkOption'];
        yield ['apiinfoVersion'];
        yield ['apiinfoTableName'];
        yield ['apiinfoPk'];
        yield ['apiinfoPkOption'];
        yield ['applicationGet'];
        yield ['applicationCreate'];
        yield ['applicationUpdate'];
        yield ['applicationDelete'];
        yield ['applicationMassAdd'];
        yield ['applicationTableName'];
        yield ['applicationPk'];
        yield ['applicationPkOption'];
        yield ['configurationExport'];
        yield ['configurationImport'];
        yield ['configurationTableName'];
        yield ['configurationPk'];
        yield ['configurationPkOption'];
        yield ['dcheckGet'];
        yield ['dcheckTableName'];
        yield ['dcheckPk'];
        yield ['dcheckPkOption'];
        yield ['dhostGet'];
        yield ['dhostTableName'];
        yield ['dhostPk'];
        yield ['dhostPkOption'];
        yield ['discoveryruleGet'];
        yield ['discoveryruleCreate'];
        yield ['discoveryruleUpdate'];
        yield ['discoveryruleDelete'];
        yield ['discoveryruleCopy'];
        yield ['discoveryruleSyncTemplates'];
        yield ['discoveryruleFindInterfaceForItem'];
        yield ['discoveryruleTableName'];
        yield ['discoveryrulePk'];
        yield ['discoveryrulePkOption'];
        yield ['druleGet'];
        yield ['druleCreate'];
        yield ['druleUpdate'];
        yield ['druleDelete'];
        yield ['druleTableName'];
        yield ['drulePk'];
        yield ['drulePkOption'];
        yield ['dserviceGet'];
        yield ['dserviceTableName'];
        yield ['dservicePk'];
        yield ['dservicePkOption'];
        yield ['eventGet'];
        yield ['eventAcknowledge'];
        yield ['eventTableName'];
        yield ['eventPk'];
        yield ['eventPkOption'];
        yield ['graphGet'];
        yield ['graphSyncTemplates'];
        yield ['graphDelete'];
        yield ['graphUpdate'];
        yield ['graphCreate'];
        yield ['graphTableName'];
        yield ['graphPk'];
        yield ['graphPkOption'];
        yield ['graphitemGet'];
        yield ['graphitemTableName'];
        yield ['graphitemPk'];
        yield ['graphitemPkOption'];
        yield ['graphprototypeGet'];
        yield ['graphprototypeSyncTemplates'];
        yield ['graphprototypeDelete'];
        yield ['graphprototypeUpdate'];
        yield ['graphprototypeCreate'];
        yield ['graphprototypeTableName'];
        yield ['graphprototypePk'];
        yield ['graphprototypePkOption'];
        yield ['hostGet'];
        yield ['hostCreate'];
        yield ['hostUpdate'];
        yield ['hostMassAdd'];
        yield ['hostMassUpdate'];
        yield ['hostMassRemove'];
        yield ['hostDelete'];
        yield ['hostTableName'];
        yield ['hostPk'];
        yield ['hostPkOption'];
        yield ['hostgroupGet'];
        yield ['hostgroupCreate'];
        yield ['hostgroupUpdate'];
        yield ['hostgroupDelete'];
        yield ['hostgroupMassAdd'];
        yield ['hostgroupMassRemove'];
        yield ['hostgroupMassUpdate'];
        yield ['hostgroupTableName'];
        yield ['hostgroupPk'];
        yield ['hostgroupPkOption'];
        yield ['hostprototypeGet'];
        yield ['hostprototypeCreate'];
        yield ['hostprototypeUpdate'];
        yield ['hostprototypeSyncTemplates'];
        yield ['hostprototypeDelete'];
        yield ['hostprototypeTableName'];
        yield ['hostprototypePk'];
        yield ['hostprototypePkOption'];
        yield ['historyGet'];
        yield ['historyTableName'];
        yield ['historyPk'];
        yield ['historyPkOption'];
        yield ['hostinterfaceGet'];
        yield ['hostinterfaceCreate'];
        yield ['hostinterfaceUpdate'];
        yield ['hostinterfaceDelete'];
        yield ['hostinterfaceMassAdd'];
        yield ['hostinterfaceMassRemove'];
        yield ['hostinterfaceReplaceHostInterfaces'];
        yield ['hostinterfaceTableName'];
        yield ['hostinterfacePk'];
        yield ['hostinterfacePkOption'];
        yield ['imageGet'];
        yield ['imageCreate'];
        yield ['imageUpdate'];
        yield ['imageDelete'];
        yield ['imageTableName'];
        yield ['imagePk'];
        yield ['imagePkOption'];
        yield ['iconmapGet'];
        yield ['iconmapCreate'];
        yield ['iconmapUpdate'];
        yield ['iconmapDelete'];
        yield ['iconmapTableName'];
        yield ['iconmapPk'];
        yield ['iconmapPkOption'];
        yield ['itemGet'];
        yield ['itemCreate'];
        yield ['itemUpdate'];
        yield ['itemDelete'];
        yield ['itemSyncTemplates'];
        yield ['itemValidateInventoryLinks'];
        yield ['itemAddRelatedObjects'];
        yield ['itemFindInterfaceForItem'];
        yield ['itemTableName'];
        yield ['itemPk'];
        yield ['itemPkOption'];
        yield ['itemprototypeGet'];
        yield ['itemprototypeCreate'];
        yield ['itemprototypeUpdate'];
        yield ['itemprototypeDelete'];
        yield ['itemprototypeSyncTemplates'];
        yield ['itemprototypeAddRelatedObjects'];
        yield ['itemprototypeFindInterfaceForItem'];
        yield ['itemprototypeTableName'];
        yield ['itemprototypePk'];
        yield ['itemprototypePkOption'];
        yield ['maintenanceGet'];
        yield ['maintenanceCreate'];
        yield ['maintenanceUpdate'];
        yield ['maintenanceDelete'];
        yield ['maintenanceTableName'];
        yield ['maintenancePk'];
        yield ['maintenancePkOption'];
        yield ['mapGet'];
        yield ['mapCreate'];
        yield ['mapUpdate'];
        yield ['mapDelete'];
        yield ['mapTableName'];
        yield ['mapPk'];
        yield ['mapPkOption'];
        yield ['mediatypeGet'];
        yield ['mediatypeCreate'];
        yield ['mediatypeUpdate'];
        yield ['mediatypeDelete'];
        yield ['mediatypeTableName'];
        yield ['mediatypePk'];
        yield ['mediatypePkOption'];
        yield ['proxyGet'];
        yield ['proxyCreate'];
        yield ['proxyUpdate'];
        yield ['proxyDelete'];
        yield ['proxyTableName'];
        yield ['proxyPk'];
        yield ['proxyPkOption'];
        yield ['serviceGet'];
        yield ['serviceCreate'];
        yield ['serviceValidateUpdate'];
        yield ['serviceUpdate'];
        yield ['serviceValidateDelete'];
        yield ['serviceDelete'];
        yield ['serviceAddDependencies'];
        yield ['serviceDeleteDependencies'];
        yield ['serviceValidateAddTimes'];
        yield ['serviceAddTimes'];
        yield ['serviceGetSla'];
        yield ['serviceDeleteTimes'];
        yield ['serviceTableName'];
        yield ['servicePk'];
        yield ['servicePkOption'];
        yield ['screenGet'];
        yield ['screenCreate'];
        yield ['screenUpdate'];
        yield ['screenDelete'];
        yield ['screenTableName'];
        yield ['screenPk'];
        yield ['screenPkOption'];
        yield ['screenitemGet'];
        yield ['screenitemCreate'];
        yield ['screenitemUpdate'];
        yield ['screenitemUpdateByPosition'];
        yield ['screenitemDelete'];
        yield ['screenitemTableName'];
        yield ['screenitemPk'];
        yield ['screenitemPkOption'];
        yield ['scriptGet'];
        yield ['scriptCreate'];
        yield ['scriptUpdate'];
        yield ['scriptDelete'];
        yield ['scriptExecute'];
        yield ['scriptGetScriptsByHosts'];
        yield ['scriptTableName'];
        yield ['scriptPk'];
        yield ['scriptPkOption'];
        yield ['templatePkOption'];
        yield ['templateGet'];
        yield ['templateCreate'];
        yield ['templateUpdate'];
        yield ['templateDelete'];
        yield ['templateMassAdd'];
        yield ['templateMassUpdate'];
        yield ['templateMassRemove'];
        yield ['templateTableName'];
        yield ['templatePk'];
        yield ['templatescreenGet'];
        yield ['templatescreenCopy'];
        yield ['templatescreenUpdate'];
        yield ['templatescreenCreate'];
        yield ['templatescreenDelete'];
        yield ['templatescreenTableName'];
        yield ['templatescreenPk'];
        yield ['templatescreenPkOption'];
        yield ['templatescreenitemGet'];
        yield ['templatescreenitemTableName'];
        yield ['templatescreenitemPk'];
        yield ['templatescreenitemPkOption'];
        yield ['trendGet'];
        yield ['trendTableName'];
        yield ['trendPk'];
        yield ['trendPkOption'];
        yield ['triggerGet'];
        yield ['triggerCreate'];
        yield ['triggerUpdate'];
        yield ['triggerDelete'];
        yield ['triggerAddDependencies'];
        yield ['triggerDeleteDependencies'];
        yield ['triggerSyncTemplates'];
        yield ['triggerSyncTemplateDependencies'];
        yield ['triggerTableName'];
        yield ['triggerPk'];
        yield ['triggerPkOption'];
        yield ['triggerprototypeGet'];
        yield ['triggerprototypeCreate'];
        yield ['triggerprototypeUpdate'];
        yield ['triggerprototypeDelete'];
        yield ['triggerprototypeSyncTemplateDependencies'];
        yield ['triggerprototypeSyncTemplates'];
        yield ['triggerprototypeTableName'];
        yield ['triggerprototypePk'];
        yield ['triggerprototypePkOption'];
        yield ['userGet'];
        yield ['userCreate'];
        yield ['userUpdate'];
        yield ['userUpdateProfile'];
        yield ['userDelete'];
        yield ['userAddMedia'];
        yield ['userUpdateMedia'];
        yield ['userDeleteMedia'];
        yield ['userCheckAuthentication'];
        yield ['userTableName'];
        yield ['userPk'];
        yield ['userPkOption'];
        yield ['usergroupGet'];
        yield ['usergroupCreate'];
        yield ['usergroupUpdate'];
        yield ['usergroupMassAdd'];
        yield ['usergroupMassUpdate'];
        yield ['usergroupDelete'];
        yield ['usergroupTableName'];
        yield ['usergroupPk'];
        yield ['usergroupPkOption'];
        yield ['usermacroGet'];
        yield ['usermacroCreateGlobal'];
        yield ['usermacroUpdateGlobal'];
        yield ['usermacroDeleteGlobal'];
        yield ['usermacroCreate'];
        yield ['usermacroUpdate'];
        yield ['usermacroDelete'];
        yield ['usermacroReplaceMacros'];
        yield ['usermacroTableName'];
        yield ['usermacroPk'];
        yield ['usermacroPkOption'];
        yield ['usermediaGet'];
        yield ['usermediaTableName'];
        yield ['usermediaPk'];
        yield ['usermediaPkOption'];
        yield ['valuemapGet'];
        yield ['valuemapCreate'];
        yield ['valuemapUpdate'];
        yield ['valuemapDelete'];
        yield ['valuemapTableName'];
        yield ['valuemapPk'];
        yield ['valuemapPkOption'];
        yield ['httptestGet'];
        yield ['httptestCreate'];
        yield ['httptestUpdate'];
        yield ['httptestDelete'];
        yield ['httptestTableName'];
        yield ['httptestPk'];
        yield ['httptestPkOption'];
    }
}
