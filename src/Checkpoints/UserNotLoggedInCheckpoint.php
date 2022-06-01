<?php

declare(strict_types=1);

namespace PoPCMSSchema\UserState\Checkpoints;

use PoP\ComponentModel\Checkpoints\AbstractCheckpoint;
use PoP\Root\Feedback\FeedbackItemResolution;
use PoP\Root\App;
use PoPCMSSchema\UserState\FeedbackItemProviders\CheckpointErrorFeedbackItemProvider;

class UserNotLoggedInCheckpoint extends AbstractCheckpoint
{
    private ?CheckpointErrorFeedbackItemProvider $checkpointErrorFeedbackItemProvider = null;

    final public function setCheckpointErrorFeedbackItemProvider(CheckpointErrorFeedbackItemProvider $checkpointErrorFeedbackItemProvider): void
    {
        $this->checkpointErrorFeedbackItemProvider = $checkpointErrorFeedbackItemProvider;
    }
    final protected function getCheckpointErrorFeedbackItemProvider(): CheckpointErrorFeedbackItemProvider
    {
        return $this->checkpointErrorFeedbackItemProvider ??= $this->instanceManager->getInstance(CheckpointErrorFeedbackItemProvider::class);
    }

    public function validateCheckpoint(): ?FeedbackItemResolution
    {
        if (App::getState('is-user-logged-in')) {
            return new FeedbackItemResolution(
                CheckpointErrorFeedbackItemProvider::class,
                CheckpointErrorFeedbackItemProvider::E2
            );
        }

        return parent::validateCheckpoint();
    }
}