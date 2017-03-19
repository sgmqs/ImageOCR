<?php
/**
 * Created by PhpStorm.
 * User: mohuishou<1@lailin.xyz>
 * Date: 2017/3/19
 * Time: 23:32
 */

namespace Mohuishou\ImageOCR;

/**
 * 图像识别
 * Class ImageOCR
 * @author mohuishou<1@lailin.xyz>
 * @package Mohuishou\ImageOCR
 */
class ImageOCR{

    private $standard_data=[];

    public function __construct(Image $image,$max_grey=0)
    {
        //灰度化
        $grey_data=$image->rgb2grey();

        //背景图像灰度值
        $bg=$image->getBgGrey($grey_data);

        $max_grey==0 && $max_grey=$image::MAX_GREY;

        //二值化
        if($bg>$max_grey){
            $bg=$max_grey;
        }
        $data=$image->imageHash($grey_data,$bg);

        //去噪&图片分割(连通域分割法，不含粘连字符)
        $img_con=new ImageConnect($data);
        $res=$img_con->split();

        //标准化
        foreach ($res as $v){
            $this->standard_data[]=$image->standard($v);
        }
    }

    /**
     * 获取标准化的二值化数组
     * @author mohuishou<1@lailin.xyz>
     * @return array
     */
    public function getHashData(){
        return $this->standard_data;
    }

    /**
     * 返回识别结果
     * @author mohuishou<1@lailin.xyz>
     */
    public function ocr(){

    }

    /**
     * 特征库建立
     * @author mohuishou<1@lailin.xyz>
     */
    public function study(){

    }
}