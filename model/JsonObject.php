<?php

namespace model;

class JsonObject implements \JsonSerializable {

    public function jsonSerialize(){
        return get_object_vars($this);
    }
}