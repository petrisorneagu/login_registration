<?php


class Verify
{
protected $db;
 public function __construct()
 {
     $this->db = \Database::instance();
 }

    /**
     * @return string
     */
 public static function generateLink(){
     return str_shuffle(substr(md5(time().mt_rand().time()),0,25));
 }

}