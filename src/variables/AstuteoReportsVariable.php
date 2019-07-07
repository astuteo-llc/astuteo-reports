<?php

namespace astuteo\reports\variables;
use astuteo\reports\models\SettingsModel;
use astuteo\reports\models\SettingsModel\Settings;
use astuteo\reports\Plugin;
use Craft;
use Github;
use yii\db\Exception;


class AstuteoReportsVariable
{

    private function gitUser() {
        return $user = Plugin::getInstance()->getSettings()->repoUser;
    }
    private function gitRepo() {
        return $user = Plugin::getInstance()->getSettings()->repoHandle;
    }

    public function gitFeed() {
        $client = new Github\Client();
        $method = Github\Client::AUTH_HTTP_TOKEN;
        $client->authenticate(Plugin::getInstance()->getSettings()->repoSecret, null, $method);
        return $client;
    }


    public function gitTags($limit = null) {
        $client = $this->gitFeed();
        $tags = $client->api('repo')->tags($this->gitUser(), $this->gitRepo());

        $total = sizeof($tags);
        $notShown = $total - $limit;

        $tags = array_slice($tags, 6, $limit);

        $result =  [
            'items' => $tags,
            'notShown' => $notShown
        ];

        return $result;
    }

    public function gitReleaseByTag($tag) {
        $client = $this->gitFeed();
        try {
            $result = $client->api('repo')->releases()->tag($this->gitUser(), $this->gitRepo(), $tag);
        } catch(\Exception $e) {
            return null;
        }
        return $result;
    }

    public function gitCommitSingle($sha){
        $client = $this->gitFeed();
        $commit = $client->api('repo')->commits()->show($this->gitUser(), $this->gitRepo(),$sha);
        return $commit;
    }

    public function gitCommitsBetween($params) {
        $client = $this->gitFeed();
        $since = $params['since'];
        $until = $params['until'];
        $commits = $client->api('repo')->commits()->all($this->gitUser(), $this->gitRepo(), array('since' => $since, 'until' => $until));
        return $commits;
    }

    public function gitCommitLabeled($commit) {
        $commitArray =  explode(' ',trim($commit));
        $tag = $commitArray[0];
        $message = $commit;
        $tagFormatted = strtolower(str_replace(':', '', $tag));

        if($tagFormatted === 'update' or $tagFormatted === 'remove' or $tagFormatted === 'fixed' or $tagFormatted === 'fix' or $tagFormatted === 'improve' or $tagFormatted === 'updated' or $tagFormatted === 'add') {
            $tagReturn = $tagFormatted;
            $message = str_replace($tag, '', $message);
        }
        elseif($tagFormatted === 'merge') {
            $tagReturn = $tagFormatted;
        }
        else {
            $tagReturn = null;
        }

        $commit = [
            'tag' => $tagReturn,
            'message' => $message
        ];

        return $commit;
    }

    public function astuteoReportsSettings() {
        return Plugin::getInstance()->getSettings();
    }
}