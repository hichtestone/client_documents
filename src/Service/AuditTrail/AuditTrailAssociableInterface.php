<?php

namespace App\Service\AuditTrail;

interface AuditTrailAssociableInterface
{
    public function getAuditTrailString(): string;
}
