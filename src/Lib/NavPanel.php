<?php

declare(strict_types=1);

use Stu\Component\Map\MapEnum;
use Stu\Orm\Entity\ShipInterface;

class NavPanel
{

    private $ship;

    function __construct(ShipInterface $ship)
    {
        $this->ship = $ship;
    }

    function getShip()
    {
        return $this->ship;
    }

    function getShipPosition()
    {
        if ($this->getShip()->getSystem() !== null) {
            return array(
                "cx" => $this->getShip()->getSX(),
                "cy" => $this->getShip()->getSY()
            );
        }
        return array(
            "cx" => $this->getShip()->getCX(),
            "cy" => $this->getShip()->getCY()
        );
    }

    function getMapBorders()
    {
        $starSystem = $this->getShip()->getSystem();
        if ($starSystem !== null) {
            return array(
                "mx" => $starSystem->getMaxX(),
                "my" => $starSystem->getMaxY()
            );
        }
        return array(
            "mx" => MapEnum::MAP_MAX_X,
            "my" => MapEnum::MAP_MAX_Y
        );
    }

    function getLeft()
    {
        $coords = $this->getShipPosition();
        if ($coords['cx'] - 1 < 1) {
            return new Tuple("-", "disabled");
        }
        return new Tuple(($coords['cx'] - 1) . "|" . $coords['cy'], "");
    }

    function getRight()
    {
        $coords = $this->getShipPosition();
        $borders = $this->getMapBorders();
        if ($coords['cx'] + 1 > $borders['mx']) {
            return new Tuple("-", "disabled");
        }
        return new Tuple(($coords['cx'] + 1) . "|" . $coords['cy'], "");
    }

    function getUp()
    {
        $coords = $this->getShipPosition();
        if ($coords['cy'] - 1 < 1) {
            return new Tuple("-", "disabled");
        }
        return new Tuple($coords['cx'] . "|" . ($coords['cy'] - 1), "");
    }

    function getDown()
    {
        $coords = $this->getShipPosition();
        $borders = $this->getMapBorders();
        if ($coords['cy'] + 1 > $borders['my']) {
            return new Tuple("-", "disabled");
        }
        return new Tuple($coords['cx'] . "|" . ($coords['cy'] + 1), "");
    }
}
