<?php
namespace app\common\controller;

interface ResourceInterface
{
    function retrieve();
    function read();
    function delete();
    function update();
    function create();
}