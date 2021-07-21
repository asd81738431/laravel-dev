<?php
namespace Tests\Config;

class Config
{
    protected $items = [];

    #读取config目录下.php文件类型的配置文件
    public function phpParser($configPath){
        //获取某个目录下面所有文件
        $files = scandir($configPath);
        $data = null;

        foreach ($files as $key => $file){
            if($file === '.' || $file === ".."){
                continue;
            }

            //获取文件名
            $filename = \stristr($file,'.php',true);
            //读取文件信息
            $data[$filename] = include_once($configPath.'/'.$file);
        }

        $this->items = $data;
        return $this;
    }

    public function get($keys){
        $data = $this->items;

        foreach (\explode('.',$keys) as $key => $value){
            $data = $data[$value];
        }
        return $data;
    }

    public function all(){
        return $this->items;
    }
}