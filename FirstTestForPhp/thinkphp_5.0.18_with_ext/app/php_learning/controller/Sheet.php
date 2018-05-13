<?php
namespace app\php_learning\controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use app\php_learning\controller\Mysql;
/**
 * User: chenyu_wang
 * Date: 2018/5/6
 * Time: 12:15
 */


class Sheet{

    /*
       * 初次测试
       * 2018/5/6
       * */
    public function index(){

        return "This is php_learning/Sheet/index()";
//        模块/控制器/函数
    }
    /*
    * 读取并输出
    * 2018/5/6
    * */
    public function read($filepath){



        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load("uploads\\$filepath");

        $worksheet = $spreadsheet->getActiveSheet();

        echo '<table>' . PHP_EOL;
        foreach ($worksheet->getRowIterator() as $row) {
            echo '<tr>' . PHP_EOL;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            //    even if a cell value is not set.
            // By default, only cells that have a value
            //    set will be iterated.
            foreach ($cellIterator as $cell) {
                echo '<td>' .
                    $cell->getValue() .
                    '</td>' . PHP_EOL;
            }
            echo '</tr>' . PHP_EOL;
        }
        echo '</table>' . PHP_EOL;
    }

    /*
    * 读取并存入数据库
    * 2018/5/6
    * */
    public function importdatabase($filepath){



        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load("uploads\\$filepath");

        $worksheet = $spreadsheet->getActiveSheet();

        echo '<table>' . PHP_EOL;
        foreach ($worksheet->getRowIterator() as $row) {
            echo '<tr>' . PHP_EOL;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            //    even if a cell value is not set.
            // By default, only cells that have a value
            //    set will be iterated.
            $arr = array();
            foreach ($cellIterator as $cell) {

                $arr[] = $cell->getValue() ;
            }
          $mysql = new Mysql();
            $mysql->insert($arr);
        }
        echo '</table>' . PHP_EOL;
    }

   /*
    * 初次测试phpSpreadSheet
    * 2018/5/6
    * */
    public function test(){

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');
        return "This is php_learning/Sheet/test()";
    }
}