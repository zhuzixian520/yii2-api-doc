<?php

namespace zhuzixian520\api_doc;

class AnnotationHelper
{
    /**
     * 通过控制器和其下action，获取action中的注释信息
     * @param $className
     * @param $methodName
     * @return array
     * @throws ReflectionException
     */
    public static function getNoteDetail($className, $methodName){
        $notes = ['name'=>'', 'param'=>[], 'res'=>[], 'method'=>'', 'desc'=>'', 'exception'=>[], 'token'=> 0];
        $description = '';
        $returns = [];
        $params = [];
        $rMethod = new \ReflectionMethod($className, $methodName);
        $docComment = $rMethod->getDocComment();
        $docCommentArr = explode("\n", $docComment);
        foreach ($docCommentArr as $comment) {

            $comment = trim($comment);
            //标题描述
            if (empty($description) && strpos($comment, '@') === false && strpos($comment, '/') === false) {
                $description = substr($comment, strpos($comment, '*') + 1);
                $notes['name'] = $description;
                continue;
            }

            //@desc注释
            $pos = stripos($comment, '@desc');
            if ($pos !== false) {
                $descComment = substr($comment, $pos + 5);
                $notes['desc'] = $descComment;
                continue;
            }

            //@exception注释
            $pos = stripos($comment, '@exception');
            if ($pos !== false) {
                $exceptions[] = explode(' ', trim(substr($comment, $pos + 10)));
                $notes['exception'] = $exceptions;
                continue;
            }

            //@method注释
            $pos = stripos($comment, '@method');
            if ($pos !== false) {
                $method = substr($comment, $pos + 8);
                $notes['method'] = $method;
                continue;
            }

            //@token注释
            $pos = stripos($comment, '@token');
            if ($pos !== false) {
                $token = substr($comment, $pos + 7);
                $notes['token'] = $token;
                continue;
            }

            //@param注释
            $pos = stripos($comment, '@param');
            if ($pos !== false) {
                $paramCommentArr = explode(' ', substr($comment, $pos + 7));
                //$paramCommentArr = array_values(array_filter($paramCommentArr));
                $params[] = $paramCommentArr;
                $notes['param'] = $params;
                continue;
            }

            //@res注释
            $pos = stripos($comment, '@res');
            if ($pos === false) {
                continue;
            }
            $returnCommentArr = explode(' ', substr($comment, $pos + 5));
            //将数组中的空值过滤掉，同时将需要展示的值返回
            $returnCommentArr = array_values(array_filter($returnCommentArr));
            if (count($returnCommentArr) < 2) {
                continue;
            }
            if (!isset($returnCommentArr[2])) {
                $returnCommentArr[2] = '';	//可选的字段说明
            } else {
                //兼容处理有空格的注释
                $returnCommentArr[2] = implode(' ', array_slice($returnCommentArr, 2));

            }
            $returns[] = $returnCommentArr;
            $notes['res'] = $returns;
        }

        return $notes;
    }

    /**
     * 把字符串中所有的空格去掉
     * @param $str
     * @return mixed
     */
    public static function trimAll($str){
        $str = trim($str);
        $old_char = [' ', '　', '\t', '\n', '\r', '&nbsp;'];
        return str_replace($old_char, '', $str);
    }
}