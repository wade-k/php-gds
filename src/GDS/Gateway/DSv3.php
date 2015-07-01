<?php

namespace GDS\Gateway

class DSv3 extends \GDS\Gateway {
    protected function upsert(array $gds_entities) {
        $request = new PutRequest();
        $autoid_entities = [];
        foreach($gds_entities as $gds_entity) {
            $g_entity = $request->addEntity();
            if($this->needsAutoId($gds_entity)) {
                $autoid_entities[] = $gds_entity;
            }
            $this->determineMapper($gds_entity)
                 ->mapToGoogle($gds_entity, $g_entity);
        }
        $this->execute('Commit', $request, new PutResponse());
    }

    protected function extractAutoIDs() {
    }
    protected function fetchByKeyPart(array $arr_key_parts, $str_setter) {
    }
    public function deleteMulti(array $arr_entities){
    }
    public function gql($str_gql, $arr_params = NULL) {
    }
    public function getEndCursor() {
    }
    protected function createMapper() {
    }
    public function beginTransaction($bol_cross_group = FALSE) {
    }

    private function needsAutoId(Entity $gds_entity) {
            return $gds_entity->getKeyId() == NULL && $gds_entity->getKeyName() == NULL;
    }

    private function execute($command, $request, $response) {
        ApiProxy::makeSyncCall('datastore_v3', $command, $request, $response, 60);
    }
}
