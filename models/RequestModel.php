<?php


class RequestModel
{
    public static function insertXML($data)
    {
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->load("requests.xml");

        $root = $doc->documentElement;
        $totalRequest = $root->getAttribute('ids');
        $node = $doc->createElement("request");
        $node->setAttribute("id", $totalRequest);
        $totalRequest++;
        $root->setAttribute("ids", $totalRequest);

        foreach ($data as $key => $value) {
            $node->appendChild($doc->createElement($key, $value));
        }
        $root->appendChild($node);

        $doc->save('requests.xml');
    }

    public static function deleteXML($id)
    {
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->load("requests.xml");

        $root = $doc->documentElement;
        $request = $root->getElementsByTagName('request');

        foreach ($request as $nodeToRemove) {
            if ($nodeToRemove->getAttribute('id') == $id) {
                $root->removeChild($nodeToRemove);
                break;
            }
        }

        $doc->save('requests.xml');
    }

    public static function getXML($name, $order)
    {
        $xml = simplexml_load_file('requests.xml');
        $res = [];
        foreach ($xml->request as $item) {
            $res[] = [
                'fname' => (string)$item->fname,
                'lname' => (string)$item->lname,
                'email' => (string)$item->email,
                'tel' => (string)$item->tel,
            ];
        }

        if ($name !== null && $order !== null) {
            $res = RequestModel::sortArrCol($res, $name, $order);
        }
        return $res;
    }

    private static function sortArrCol($arr, $nameColumn, $order)
    {
        $columnSort = array_column($arr, $nameColumn);

        array_multisort($columnSort, RequestModel::getNumberSort($order), $arr);
        return $arr;
    }

    private static function getNumberSort($sort)
    {
        return ($sort == 'asc') ? SORT_ASC : SORT_DESC;
    }
}
