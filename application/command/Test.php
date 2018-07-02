<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/5
 * 时间: 21:18
 */

namespace app\command;


use think\console\Command;
use think\console\Input;
use think\console\Output;

class Test extends Command
{
    protected function configure()
    {
        $this->setName('test')->setDescription('这是标记');
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln("very good");
    }

}