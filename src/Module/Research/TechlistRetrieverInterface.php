<?php

namespace Stu\Module\Research;

use Stu\Orm\Entity\ResearchedInterface;
use Stu\Orm\Entity\ResearchInterface;
use Stu\Orm\Entity\UserInterface;

interface TechlistRetrieverInterface
{
    /**
     * @return ResearchInterface[]
     */
    public function getResearchList(UserInterface $user): array;

    /**
     * @return ResearchedInterface[]
     */
    public function getFinishedResearchList(UserInterface $user): array;
}
