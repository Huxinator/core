<?php

declare(strict_types=1);

namespace Stu\Module\Ship\Action\ActivateTorpedo;

use request;
use Stu\Component\Ship\System\Exception\InsufficientEnergyException;
use Stu\Component\Ship\System\Exception\ShipSystemException;
use Stu\Component\Ship\System\Exception\SystemDamagedException;
use Stu\Component\Ship\System\ShipSystemManagerInterface;
use Stu\Component\Ship\System\ShipSystemTypeEnum;
use Stu\Module\Control\ActionControllerInterface;
use Stu\Module\Control\GameControllerInterface;
use Stu\Module\Ship\Lib\ShipLoaderInterface;
use Stu\Module\Ship\View\ShowShip\ShowShip;
use Stu\Orm\Repository\ShipRepositoryInterface;

final class ActivateTorpedo implements ActionControllerInterface
{
    public const ACTION_IDENTIFIER = 'B_ACTIVATE_TORPEDO';

    private ShipLoaderInterface $shipLoader;

    private ShipRepositoryInterface $shipRepository;

    private ShipSystemManagerInterface $shipSystemManager;

    public function __construct(
        ShipLoaderInterface $shipLoader,
        ShipRepositoryInterface $shipRepository,
        ShipSystemManagerInterface $shipSystemManager
    ) {
        $this->shipLoader = $shipLoader;
        $this->shipRepository = $shipRepository;
        $this->shipSystemManager = $shipSystemManager;
    }

    public function handle(GameControllerInterface $game): void
    {
        $game->setView(ShowShip::VIEW_IDENTIFIER);

        $userId = $game->getUser()->getId();

        $ship = $this->shipLoader->getByIdAndUser(
            request::indInt('id'),
            $userId
        );

        try {
            $this->shipSystemManager->activate(
                $ship,
                ShipSystemTypeEnum::SYSTEM_TORPEDO
            );

            $this->shipRepository->save($ship);
        } catch (InsufficientEnergyException $e) {
            $game->addInformation(_('Nicht genügend Energie zur Aktivierung vorhanden'));
            return;
        } catch (SystemDamagedException $e) {
            $game->addInformation(_('Die Projektilwaffe ist beschädigt und kann nicht aktiviert werden'));
            return;
        } catch (ShipSystemException $e) {
            $game->addInformation(_('Die Projektilwaffe kann nicht aktiviert werden'));
            return;
        }

        $this->shipRepository->save($ship);

        $game->addInformation("Projektilwaffe aktiviert");
    }

    public function performSessionCheck(): bool
    {
        return true;
    }
}
