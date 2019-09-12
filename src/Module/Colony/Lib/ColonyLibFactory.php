<?php

declare(strict_types=1);

namespace Stu\Module\Colony\Lib;

use ShipData;

final class ColonyLibFactory implements ColonyLibFactoryInterface
{
    public function createOrbitShipItem(
        ShipData $ship,
        int $ownerUserId
    ): OrbitShipItemInterface {
        return new OrbitShipItem(
            $ship,
            $ownerUserId
        );
    }

    public function createOrbitFleetItem(
        int $fleetId,
        array $shipList,
        int $ownerUserId
    ): OrbitFleetItemInterface {
        return new OrbitFleetItem(
            $fleetId,
            $shipList,
            $ownerUserId
        );
    }

    public function createBuildingFunctionTal(
        array $buildingFunctionIds
    ): BuildingFunctionTalInterface {
        return new BuildingFunctionTal($buildingFunctionIds);
    }
}