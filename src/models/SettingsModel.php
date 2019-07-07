<?php

namespace astuteo\reports\models;

use craft\base\Model;

class SettingsModel extends Model
{
    public $cpLabel = '';
    public $repoUser = 'astuteo-llc';
    public $repoHandle = '';
    public $repoSecret = '';
    public $seoAuditSections = array();
    public $loadCpTweaks = false;
    public $showGitReporter = false;
    public $titleGitReporter = '';
    public $descriptionGitReporter = '';
    public $loadSeoAudit = false;
    public $allowQuickSeoEdit = false;
}


