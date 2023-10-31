<?php

namespace App\Service\AuditTrail;

interface AuditrailableInterface
{
    public function getFieldsToBeIgnored(): array;
}
