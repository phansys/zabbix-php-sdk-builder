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

namespace Confirm\ZabbixSdkBuilder\Tests;

use Confirm\ZabbixApi\TokenCacheAwareInterface;
use Confirm\ZabbixApi\ZabbixApi;
use Confirm\ZabbixApi\ZabbixApiInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Javier Spagnoletti <phansys@gmail.com>
 */
final class BuildTest extends TestCase
{
    public function testZabbixClass(): void
    {
        $this->assertTrue(class_exists(ZabbixApi::class));
        $this->assertTrue(is_subclass_of(ZabbixApi::class, ZabbixApiInterface::class));
        $this->assertTrue(is_subclass_of(ZabbixApi::class, TokenCacheAwareInterface::class));
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
        $this->assertTrue(method_exists(ZabbixApiInterface::class, $methodName));
    }

    public function provideMethodNames(): iterable
    {
        yield ['actionCreate'];
        yield ['actionDelete'];
        yield ['actionGet'];
        yield ['actionPk'];
        yield ['actionPkOption'];
        yield ['actionTableName'];
        yield ['actionUpdate'];
        yield ['actionValidateOperationConditions'];
        yield ['actionValidateOperationsIntegrity'];
        yield ['alertGet'];
        yield ['alertPk'];
        yield ['alertPkOption'];
        yield ['alertTableName'];
        yield ['apiPk'];
        yield ['apiPkOption'];
        yield ['apiTableName'];
        yield ['apiinfoPk'];
        yield ['apiinfoPkOption'];
        yield ['apiinfoTableName'];
        yield ['apiinfoVersion'];
        yield ['applicationCreate'];
        yield ['applicationDelete'];
        yield ['applicationGet'];
        yield ['applicationMassAdd'];
        yield ['applicationPk'];
        yield ['applicationPkOption'];
        yield ['applicationTableName'];
        yield ['applicationUpdate'];
        yield ['configurationExport'];
        yield ['configurationImport'];
        yield ['configurationPk'];
        yield ['configurationPkOption'];
        yield ['configurationTableName'];
        yield ['dcheckGet'];
        yield ['dcheckPk'];
        yield ['dcheckPkOption'];
        yield ['dcheckTableName'];
        yield ['dhostGet'];
        yield ['dhostPk'];
        yield ['dhostPkOption'];
        yield ['dhostTableName'];
        yield ['discoveryruleCopy'];
        yield ['discoveryruleCreate'];
        yield ['discoveryruleDelete'];
        yield ['discoveryruleFindInterfaceForItem'];
        yield ['discoveryruleGet'];
        yield ['discoveryrulePk'];
        yield ['discoveryrulePkOption'];
        yield ['discoveryruleSyncTemplates'];
        yield ['discoveryruleTableName'];
        yield ['discoveryruleUpdate'];
        yield ['druleCreate'];
        yield ['druleDelete'];
        yield ['druleGet'];
        yield ['drulePk'];
        yield ['drulePkOption'];
        yield ['druleTableName'];
        yield ['druleUpdate'];
        yield ['dserviceGet'];
        yield ['dservicePk'];
        yield ['dservicePkOption'];
        yield ['dserviceTableName'];
        yield ['eventAcknowledge'];
        yield ['eventGet'];
        yield ['eventPk'];
        yield ['eventPkOption'];
        yield ['eventTableName'];
        yield ['graphCreate'];
        yield ['graphDelete'];
        yield ['graphGet'];
        yield ['graphPk'];
        yield ['graphPkOption'];
        yield ['graphSyncTemplates'];
        yield ['graphTableName'];
        yield ['graphUpdate'];
        yield ['graphitemGet'];
        yield ['graphitemPk'];
        yield ['graphitemPkOption'];
        yield ['graphitemTableName'];
        yield ['graphprototypeCreate'];
        yield ['graphprototypeDelete'];
        yield ['graphprototypeGet'];
        yield ['graphprototypePk'];
        yield ['graphprototypePkOption'];
        yield ['graphprototypeSyncTemplates'];
        yield ['graphprototypeTableName'];
        yield ['graphprototypeUpdate'];
        yield ['historyGet'];
        yield ['historyPk'];
        yield ['historyPkOption'];
        yield ['historyTableName'];
        yield ['hostCreate'];
        yield ['hostDelete'];
        yield ['hostGet'];
        yield ['hostMassAdd'];
        yield ['hostMassRemove'];
        yield ['hostMassUpdate'];
        yield ['hostPk'];
        yield ['hostPkOption'];
        yield ['hostTableName'];
        yield ['hostUpdate'];
        yield ['hostgroupCreate'];
        yield ['hostgroupDelete'];
        yield ['hostgroupGet'];
        yield ['hostgroupMassAdd'];
        yield ['hostgroupMassRemove'];
        yield ['hostgroupMassUpdate'];
        yield ['hostgroupPk'];
        yield ['hostgroupPkOption'];
        yield ['hostgroupTableName'];
        yield ['hostgroupUpdate'];
        yield ['hostinterfaceCreate'];
        yield ['hostinterfaceDelete'];
        yield ['hostinterfaceGet'];
        yield ['hostinterfaceMassAdd'];
        yield ['hostinterfaceMassRemove'];
        yield ['hostinterfacePk'];
        yield ['hostinterfacePkOption'];
        yield ['hostinterfaceReplaceHostInterfaces'];
        yield ['hostinterfaceTableName'];
        yield ['hostinterfaceUpdate'];
        yield ['hostprototypeCreate'];
        yield ['hostprototypeDelete'];
        yield ['hostprototypeGet'];
        yield ['hostprototypePk'];
        yield ['hostprototypePkOption'];
        yield ['hostprototypeSyncTemplates'];
        yield ['hostprototypeTableName'];
        yield ['hostprototypeUpdate'];
        yield ['httptestCreate'];
        yield ['httptestDelete'];
        yield ['httptestGet'];
        yield ['httptestPk'];
        yield ['httptestPkOption'];
        yield ['httptestTableName'];
        yield ['httptestUpdate'];
        yield ['iconmapCreate'];
        yield ['iconmapDelete'];
        yield ['iconmapGet'];
        yield ['iconmapPk'];
        yield ['iconmapPkOption'];
        yield ['iconmapTableName'];
        yield ['iconmapUpdate'];
        yield ['imageCreate'];
        yield ['imageDelete'];
        yield ['imageGet'];
        yield ['imagePk'];
        yield ['imagePkOption'];
        yield ['imageTableName'];
        yield ['imageUpdate'];
        yield ['itemAddRelatedObjects'];
        yield ['itemCreate'];
        yield ['itemDelete'];
        yield ['itemFindInterfaceForItem'];
        yield ['itemGet'];
        yield ['itemPk'];
        yield ['itemPkOption'];
        yield ['itemSyncTemplates'];
        yield ['itemTableName'];
        yield ['itemUpdate'];
        yield ['itemValidateInventoryLinks'];
        yield ['itemprototypeAddRelatedObjects'];
        yield ['itemprototypeCreate'];
        yield ['itemprototypeDelete'];
        yield ['itemprototypeFindInterfaceForItem'];
        yield ['itemprototypeGet'];
        yield ['itemprototypePk'];
        yield ['itemprototypePkOption'];
        yield ['itemprototypeSyncTemplates'];
        yield ['itemprototypeTableName'];
        yield ['itemprototypeUpdate'];
        yield ['maintenanceCreate'];
        yield ['maintenanceDelete'];
        yield ['maintenanceGet'];
        yield ['maintenancePk'];
        yield ['maintenancePkOption'];
        yield ['maintenanceTableName'];
        yield ['maintenanceUpdate'];
        yield ['mapCreate'];
        yield ['mapDelete'];
        yield ['mapGet'];
        yield ['mapPk'];
        yield ['mapPkOption'];
        yield ['mapTableName'];
        yield ['mapUpdate'];
        yield ['mediatypeCreate'];
        yield ['mediatypeDelete'];
        yield ['mediatypeGet'];
        yield ['mediatypePk'];
        yield ['mediatypePkOption'];
        yield ['mediatypeTableName'];
        yield ['mediatypeUpdate'];
        yield ['proxyCreate'];
        yield ['proxyDelete'];
        yield ['proxyGet'];
        yield ['proxyPk'];
        yield ['proxyPkOption'];
        yield ['proxyTableName'];
        yield ['proxyUpdate'];
        yield ['screenCreate'];
        yield ['screenDelete'];
        yield ['screenGet'];
        yield ['screenPk'];
        yield ['screenPkOption'];
        yield ['screenTableName'];
        yield ['screenUpdate'];
        yield ['screenitemCreate'];
        yield ['screenitemDelete'];
        yield ['screenitemGet'];
        yield ['screenitemPk'];
        yield ['screenitemPkOption'];
        yield ['screenitemTableName'];
        yield ['screenitemUpdate'];
        yield ['screenitemUpdateByPosition'];
        yield ['scriptCreate'];
        yield ['scriptDelete'];
        yield ['scriptExecute'];
        yield ['scriptGet'];
        yield ['scriptGetScriptsByHosts'];
        yield ['scriptPk'];
        yield ['scriptPkOption'];
        yield ['scriptTableName'];
        yield ['scriptUpdate'];
        yield ['serviceAddDependencies'];
        yield ['serviceAddTimes'];
        yield ['serviceCreate'];
        yield ['serviceDelete'];
        yield ['serviceDeleteDependencies'];
        yield ['serviceDeleteTimes'];
        yield ['serviceGet'];
        yield ['serviceGetSla'];
        yield ['servicePk'];
        yield ['servicePkOption'];
        yield ['serviceTableName'];
        yield ['serviceUpdate'];
        yield ['serviceValidateAddTimes'];
        yield ['serviceValidateDelete'];
        yield ['serviceValidateUpdate'];
        yield ['templateCreate'];
        yield ['templateDelete'];
        yield ['templateGet'];
        yield ['templateMassAdd'];
        yield ['templateMassRemove'];
        yield ['templateMassUpdate'];
        yield ['templatePk'];
        yield ['templatePkOption'];
        yield ['templateTableName'];
        yield ['templateUpdate'];
        yield ['templatescreenCopy'];
        yield ['templatescreenCreate'];
        yield ['templatescreenDelete'];
        yield ['templatescreenGet'];
        yield ['templatescreenPk'];
        yield ['templatescreenPkOption'];
        yield ['templatescreenTableName'];
        yield ['templatescreenUpdate'];
        yield ['templatescreenitemGet'];
        yield ['templatescreenitemPk'];
        yield ['templatescreenitemPkOption'];
        yield ['templatescreenitemTableName'];
        yield ['trendGet'];
        yield ['trendPk'];
        yield ['trendPkOption'];
        yield ['trendTableName'];
        yield ['triggerAddDependencies'];
        yield ['triggerCreate'];
        yield ['triggerDelete'];
        yield ['triggerDeleteDependencies'];
        yield ['triggerGet'];
        yield ['triggerPk'];
        yield ['triggerPkOption'];
        yield ['triggerSyncTemplateDependencies'];
        yield ['triggerSyncTemplates'];
        yield ['triggerTableName'];
        yield ['triggerUpdate'];
        yield ['triggerprototypeCreate'];
        yield ['triggerprototypeDelete'];
        yield ['triggerprototypeGet'];
        yield ['triggerprototypePk'];
        yield ['triggerprototypePkOption'];
        yield ['triggerprototypeSyncTemplateDependencies'];
        yield ['triggerprototypeSyncTemplates'];
        yield ['triggerprototypeTableName'];
        yield ['triggerprototypeUpdate'];
        yield ['userAddMedia'];
        yield ['userCheckAuthentication'];
        yield ['userCreate'];
        yield ['userDelete'];
        yield ['userDeleteMedia'];
        yield ['userGet'];
        yield ['userLogin'];
        yield ['userLogout'];
        yield ['userPk'];
        yield ['userPkOption'];
        yield ['userTableName'];
        yield ['userUpdate'];
        yield ['userUpdateMedia'];
        yield ['userUpdateProfile'];
        yield ['usergroupCreate'];
        yield ['usergroupDelete'];
        yield ['usergroupGet'];
        yield ['usergroupMassAdd'];
        yield ['usergroupMassUpdate'];
        yield ['usergroupPk'];
        yield ['usergroupPkOption'];
        yield ['usergroupTableName'];
        yield ['usergroupUpdate'];
        yield ['usermacroCreate'];
        yield ['usermacroCreateGlobal'];
        yield ['usermacroDelete'];
        yield ['usermacroDeleteGlobal'];
        yield ['usermacroGet'];
        yield ['usermacroPk'];
        yield ['usermacroPkOption'];
        yield ['usermacroReplaceMacros'];
        yield ['usermacroTableName'];
        yield ['usermacroUpdate'];
        yield ['usermacroUpdateGlobal'];
        yield ['usermediaGet'];
        yield ['usermediaPk'];
        yield ['usermediaPkOption'];
        yield ['usermediaTableName'];
        yield ['valuemapCreate'];
        yield ['valuemapDelete'];
        yield ['valuemapGet'];
        yield ['valuemapPk'];
        yield ['valuemapPkOption'];
        yield ['valuemapTableName'];
        yield ['valuemapUpdate'];
    }
}
