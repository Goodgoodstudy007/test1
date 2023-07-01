<?php

// 版本 v1.0.6

namespace app\index\controller;

use app\common\controller\Frontend;
use think\Db;

class Updatesql extends Frontend
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        // 任务
        $fields = Db::getFields('fa_store_task');
        if(!isset($fields['max_cursor'])){
            Db::execute("ALTER TABLE fa_store_task  ADD `max_cursor` tinyint(2)  DEFAULT '0' NOT NULL;");
        }
        if(!isset($fields['show_status'])){
            Db::execute("ALTER TABLE fa_store_task  ADD `show_status` tinyint(2)  DEFAULT '1' NOT NULL;");
        }
        if(!isset($fields['error_count'])){
            Db::execute("ALTER TABLE fa_store_task  ADD `error_count` tinyint(2)  DEFAULT '0' NOT NULL;");
        }
        if(!isset($fields['auto_follow'])){
            Db::execute("ALTER TABLE fa_store_task  ADD `auto_follow` tinyint(2)  DEFAULT '0' NOT NULL;");
        }
        // 用户
        $fields = Db::getFields('fa_video_comment');
        if(!isset($fields['uid'])){
            Db::execute("ALTER TABLE fa_video_comment  ADD `uid` varchar(100)  DEFAULT '' NOT NULL;");
        }
        if(!isset($fields['sec_uid'])){
            Db::execute("ALTER TABLE fa_video_comment  ADD `sec_uid` varchar(255)  DEFAULT '' NOT NULL;");
        }
        if(!isset($fields['is_follow'])){
            Db::execute("ALTER TABLE fa_video_comment  ADD `is_follow` tinyint(1)  DEFAULT '0' NOT NULL;");
        }
        // 视频
        $fields = Db::getFields('fa_task_video');
        if(!isset($fields['is_show'])){
            Db::execute("ALTER TABLE fa_task_video  ADD `is_show` tinyint(2)  DEFAULT 1 NOT NULL;");
        }
        $fields = Db::getFields('fa_task_video');
        if(!isset($fields['is_show'])){
            Db::execute("ALTER TABLE fa_task_video  ADD `is_show` tinyint(2)  DEFAULT 1 NOT NULL;");
        }
        $fields = Db::getFields('fa_store');
        if(!isset($fields['task_count'])){
            Db::execute("ALTER TABLE fa_store  ADD `task_count` int(11)  DEFAULT 0 NOT NULL;");
        }
        // 新建cookie表
        // Db::execute("DROP TABLE IF EXISTS `fa_store_cookie`;");
        $fields = Db::execute('SHOW TABLES LIKE "fa_store_cookie" ');
        if(empty($fields)){
            Db::execute("CREATE TABLE `fa_store_cookie` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '商户id',
                      `cookie` text COLLATE utf8mb4_unicode_ci COMMENT 'cookie',
                      `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '平台：1抖音',
                      `title` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '账号标识',
                      `max_follow` int(11) NOT NULL DEFAULT '0' COMMENT '每日最大关注',
                      `today_follow` int(11) NOT NULL DEFAULT '0' COMMENT '今日关注',
                      `all_follow` int(11) NOT NULL DEFAULT '0' COMMENT '总关注',
                      `addtime` datetime DEFAULT NULL,
                      `uptime` datetime DEFAULT NULL,
                      `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态0失效',
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        }

        $has_config = Db::name('config')->where(['name'=>'max_map_count'])->find();
        if(!$has_config){
            Db::execute("INSERT INTO `fa_config` VALUES ('31', 'max_map_count', 'basic', '地图最大客户采集', '每个地图采集任务最多采集多少客户', 'string', '100', null, '', '', '');");
        }

        $fields = Db::execute('SHOW TABLES LIKE "fa_baidu_city" ');
        if(empty($fields)){
            Db::execute("CREATE TABLE `fa_baidu_city` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `code` int(11) NOT NULL DEFAULT '0',
                          `city` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=366 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        }
        $baidu_city = Db::name('baidu_city')->count();
        if($baidu_city < 300){
            Db::execute("DELETE from `fa_baidu_city`");
            Db::execute("INSERT INTO `fa_baidu_city`  VALUES ('1', '33', '嘉峪关市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('2', '34', '金昌市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('3', '35', '白银市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('4', '36', '兰州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('5', '37', '酒泉市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('6', '38', '大兴安岭地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('7', '39', '黑河市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('8', '40', '伊春市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('9', '41', '齐齐哈尔市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('10', '42', '佳木斯市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('11', '43', '鹤岗市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('12', '44', '绥化市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('13', '45', '双鸭山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('14', '46', '鸡西市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('15', '47', '七台河市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('16', '48', '哈尔滨市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('17', '49', '牡丹江市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('18', '50', '大庆市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('19', '51', '白城市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('20', '52', '松原市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('21', '53', '长春市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('22', '54', '延边朝鲜族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('23', '55', '吉林市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('24', '56', '四平市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('25', '57', '白山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('26', '58', '沈阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('27', '59', '阜新市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('28', '60', '铁岭市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('29', '61', '呼伦贝尔市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('30', '62', '兴安盟');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('31', '63', '锡林郭勒盟');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('32', '64', '通辽市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('33', '65', '海西蒙古族藏族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('34', '66', '西宁市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('35', '67', '海北藏族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('36', '68', '海南藏族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('37', '69', '海东地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('38', '70', '黄南藏族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('39', '71', '玉树藏族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('40', '72', '果洛藏族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('41', '73', '甘孜藏族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('42', '74', '德阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('43', '75', '成都市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('44', '76', '雅安市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('45', '77', '眉山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('46', '78', '自贡市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('47', '79', '乐山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('48', '80', '凉山彝族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('49', '81', '攀枝花市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('50', '82', '和田地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('51', '83', '喀什地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('52', '84', '克孜勒苏柯尔克孜自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('53', '85', '阿克苏地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('54', '86', '巴音郭楞蒙古自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('55', '88', '博尔塔拉蒙古自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('56', '89', '吐鲁番地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('57', '90', '伊犁哈萨克自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('58', '91', '哈密地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('59', '92', '乌鲁木齐市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('60', '93', '昌吉回族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('61', '94', '塔城地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('62', '95', '克拉玛依市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('63', '96', '阿勒泰地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('64', '97', '山南地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('65', '98', '林芝地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('66', '99', '昌都地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('67', '100', '拉萨市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('68', '101', '那曲地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('69', '102', '日喀则地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('70', '103', '阿里地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('71', '104', '昆明市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('72', '105', '楚雄彝族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('73', '106', '玉溪市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('74', '107', '红河哈尼族彝族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('75', '108', '普洱市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('76', '109', '西双版纳傣族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('77', '110', '临沧市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('78', '111', '大理白族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('79', '112', '保山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('80', '113', '怒江傈僳族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('81', '114', '丽江市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('82', '115', '迪庆藏族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('83', '116', '德宏傣族景颇族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('84', '117', '张掖市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('85', '118', '武威市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('86', '119', '东莞市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('87', '120', '东沙群岛');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('88', '121', '三亚市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('89', '122', '鄂州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('90', '123', '乌海市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('91', '124', '莱芜市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('92', '125', '海口市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('93', '126', '蚌埠市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('94', '127', '合肥市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('95', '128', '阜阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('96', '129', '芜湖市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('97', '130', '安庆市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('98', '131', '北京市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('99', '132', '重庆市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('100', '133', '南平市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('101', '134', '泉州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('102', '135', '庆阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('103', '136', '定西市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('104', '137', '韶关市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('105', '138', '佛山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('106', '139', '茂名市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('107', '140', '珠海市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('108', '141', '梅州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('109', '142', '桂林市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('110', '143', '河池市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('111', '144', '崇左市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('112', '145', '钦州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('113', '146', '贵阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('114', '147', '六盘水市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('115', '148', '秦皇岛市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('116', '149', '沧州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('117', '150', '石家庄市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('118', '151', '邯郸市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('119', '152', '新乡市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('120', '153', '洛阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('121', '154', '商丘市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('122', '155', '许昌市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('123', '156', '襄阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('124', '157', '荆州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('125', '158', '长沙市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('126', '159', '衡阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('127', '160', '镇江市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('128', '161', '南通市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('129', '162', '淮安市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('130', '163', '南昌市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('131', '164', '新余市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('132', '165', '通化市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('133', '166', '锦州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('134', '167', '大连市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('135', '168', '乌兰察布市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('136', '169', '巴彦淖尔市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('137', '170', '渭南市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('138', '171', '宝鸡市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('139', '172', '枣庄市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('140', '173', '日照市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('141', '174', '东营市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('142', '175', '威海市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('143', '176', '太原市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('144', '177', '文山壮族苗族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('145', '178', '温州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('146', '179', '杭州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('147', '180', '宁波市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('148', '181', '中卫市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('149', '182', '临夏回族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('150', '183', '辽源市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('151', '184', '抚顺市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('152', '185', '阿坝藏族羌族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('153', '186', '宜宾市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('154', '187', '中山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('155', '188', '亳州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('156', '189', '滁州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('157', '190', '宣城市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('158', '191', '廊坊市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('159', '192', '宁德市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('160', '193', '龙岩市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('161', '194', '厦门市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('162', '195', '莆田市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('163', '196', '天水市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('164', '197', '清远市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('165', '198', '湛江市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('166', '199', '阳江市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('167', '200', '河源市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('168', '201', '潮州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('169', '202', '来宾市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('170', '203', '百色市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('171', '204', '防城港市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('172', '205', '铜仁地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('173', '206', '毕节地区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('174', '207', '承德市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('175', '209', '濮阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('176', '210', '开封市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('177', '211', '焦作市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('178', '212', '三门峡市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('179', '213', '平顶山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('180', '214', '信阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('181', '215', '鹤壁市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('182', '216', '十堰市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('183', '217', '荆门市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('184', '218', '武汉市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('185', '219', '常德市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('186', '220', '岳阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('187', '221', '娄底市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('188', '222', '株洲市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('189', '223', '盐城市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('190', '224', '苏州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('191', '225', '景德镇市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('192', '226', '抚州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('193', '227', '本溪市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('194', '228', '盘锦市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('195', '229', '包头市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('196', '230', '阿拉善盟');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('197', '231', '榆林市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('198', '232', '铜川市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('199', '233', '西安市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('200', '234', '临沂市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('201', '235', '滨州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('202', '236', '青岛市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('203', '237', '朔州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('204', '238', '晋中市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('205', '239', '巴中市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('206', '240', '绵阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('207', '241', '广安市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('208', '242', '资阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('209', '243', '衢州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('210', '244', '台州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('211', '245', '舟山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('212', '246', '固原市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('213', '247', '甘南藏族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('214', '248', '内江市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('215', '249', '曲靖市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('216', '250', '淮南市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('217', '251', '巢湖市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('218', '252', '黄山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('219', '253', '淮北市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('220', '254', '三明市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('221', '255', '漳州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('222', '256', '陇南市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('223', '257', '广州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('224', '258', '云浮市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('225', '259', '揭阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('226', '260', '贺州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('227', '261', '南宁市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('228', '262', '遵义市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('229', '263', '安顺市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('230', '264', '张家口市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('231', '265', '唐山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('232', '266', '邢台市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('233', '267', '安阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('234', '268', '郑州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('235', '269', '驻马店市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('236', '270', '宜昌市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('237', '271', '黄冈市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('238', '272', '益阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('239', '273', '邵阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('240', '274', '湘西土家族苗族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('241', '275', '郴州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('242', '276', '泰州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('243', '277', '宿迁市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('244', '278', '宜春市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('245', '279', '鹰潭市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('246', '280', '朝阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('247', '281', '营口市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('248', '282', '丹东市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('249', '283', '鄂尔多斯市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('250', '284', '延安市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('251', '285', '商洛市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('252', '286', '济宁市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('253', '287', '潍坊市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('254', '288', '济南市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('255', '289', '上海市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('256', '290', '晋城市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('257', '291', '南充市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('258', '292', '丽水市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('259', '293', '绍兴市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('260', '294', '湖州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('261', '295', '北海市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('262', '297', '赤峰市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('263', '298', '六安市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('264', '299', '池州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('265', '300', '福州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('266', '301', '惠州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('267', '302', '江门市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('268', '303', '汕头市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('269', '304', '梧州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('270', '305', '柳州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('271', '306', '黔南布依族苗族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('272', '307', '保定市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('273', '308', '周口市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('274', '309', '南阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('275', '310', '孝感市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('276', '311', '黄石市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('277', '312', '张家界市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('278', '313', '湘潭市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('279', '314', '永州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('280', '315', '南京市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('281', '316', '徐州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('282', '317', '无锡市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('283', '318', '吉安市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('284', '319', '葫芦岛市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('285', '320', '鞍山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('286', '321', '呼和浩特市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('287', '322', '吴忠市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('288', '323', '咸阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('289', '324', '安康市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('290', '325', '泰安市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('291', '326', '烟台市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('292', '327', '吕梁市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('293', '328', '运城市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('294', '329', '广元市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('295', '330', '遂宁市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('296', '331', '泸州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('297', '332', '天津市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('298', '333', '金华市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('299', '334', '嘉兴市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('300', '335', '石嘴山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('301', '336', '昭通市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('302', '337', '铜陵市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('303', '338', '肇庆市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('304', '339', '汕尾市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('305', '340', '深圳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('306', '341', '贵港市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('307', '342', '黔东南苗族侗族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('308', '343', '黔西南布依族苗族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('309', '344', '漯河市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('310', '346', '扬州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('311', '347', '连云港市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('312', '348', '常州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('313', '349', '九江市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('314', '350', '萍乡市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('315', '351', '辽阳市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('316', '352', '汉中市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('317', '353', '菏泽市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('318', '354', '淄博市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('319', '355', '大同市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('320', '356', '长治市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('321', '357', '阳泉市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('322', '358', '马鞍山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('323', '359', '平凉市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('324', '360', '银川市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('325', '361', '玉林市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('326', '362', '咸宁市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('327', '363', '怀化市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('328', '364', '上饶市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('329', '365', '赣州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('330', '366', '聊城市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('331', '367', '忻州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('332', '368', '临汾市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('333', '369', '达州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('334', '370', '宿州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('335', '371', '随州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('336', '372', '德州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('337', '373', '恩施土家族苗族自治州');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('338', '731', '阿拉尔市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('339', '770', '石河子市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('340', '789', '五家渠市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('341', '792', '图木舒克市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('342', '1214', '定安县');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('343', '1215', '儋州市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('344', '1216', '万宁市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('345', '1217', '保亭黎族苗族自治县');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('346', '1218', '西沙群岛');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('347', '1277', '济源市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('348', '1293', '潜江市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('349', '1498', '中沙群岛');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('350', '1515', '南沙群岛');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('351', '1641', '屯昌县');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('352', '1642', '昌江黎族自治县');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('353', '1643', '陵水黎族自治县');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('354', '1644', '五指山市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('355', '1713', '仙桃市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('356', '2031', '琼中黎族苗族自治县');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('357', '2032', '乐东黎族自治县');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('358', '2033', '临高县');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('359', '2358', '琼海市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('360', '2359', '白沙黎族自治县');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('361', '2634', '东方市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('362', '2654', '天门市');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('363', '2734', '神农架林区');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('364', '2757', '澄迈县');");
                        Db::execute("INSERT INTO `fa_baidu_city` VALUES ('365', '2758', '文昌市');");
        }
        

        $fields = Db::execute('SHOW TABLES LIKE "fa_map_task" ');
        if(empty($fields)){
            Db::execute("CREATE TABLE `fa_map_task` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `city_id` int(11) NOT NULL DEFAULT '0' COMMENT '百度citycode',
                          `keyword` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '任务关键词',
                          `store_id` int(11) NOT NULL DEFAULT '0',
                          `addtime` datetime DEFAULT NULL,
                          `uptime` datetime DEFAULT NULL,
                          `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1采集中 2采集完成 3暂停采集',
                          `price` int(11) NOT NULL DEFAULT '0' COMMENT '消耗点数',
                          `xunpang_count` int(11) NOT NULL DEFAULT '0' COMMENT '询盘数',
                          `cursor` int(11) NOT NULL DEFAULT '0' COMMENT '下次初始页面',
                          PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        }

        $fields = Db::execute('SHOW TABLES LIKE "fa_map_customer" ');
        if(empty($fields)){
            Db::execute("CREATE TABLE `fa_map_customer` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `map_task_id` int(11) NOT NULL DEFAULT '0' COMMENT '地图任务id',
                      `area_id` int(11) NOT NULL DEFAULT '0',
                      `area_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '区域',
                      `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '详细地址',
                      `di_tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '门店标签',
                      `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '门店名',
                      `city_id` int(11) NOT NULL DEFAULT '0',
                      `city_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                      `lng` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                      `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                      `addtime` datetime DEFAULT NULL,
                      `status` tinyint(1) NOT NULL DEFAULT '1',
                      `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        }

        
        echo '更新成功';
    }


}
