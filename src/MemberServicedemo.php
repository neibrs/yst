<?php

include_once './SDK/yunClient.php';
include_once './Log/Log.php';
include_once './Config/conf.php';

$demo = new Demo();

class Demo
{
	private  $logIns;
	private  $config;
    public function __construct(){
        $this->logIns = Log::getInstance();
		$this->config = conf::getInstance();
		$this->config->loadConf('./Config/config.php');
	
    }

    public function applyBindBankCard($bizUserId,$cardNo,$phone,$name,$cardCheck,$identityType,$identityNo,$validate=null,$cvv2=null)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$param["cardNo"] = $yunClient->encryptAES($cardNo);
		$param["phone"] = $phone;
		$param["name"] = $name;
		$param["cardCheck"] = $cardCheck;
		$param["identityType"] = $identityType;
		$param["identityNo"] = $yunClient->encryptAES($identityNo);
		$param["validate"] = $yunClient->encryptAES($validate);
		$param["cvv2"] = $yunClient->encryptAES($cvv2);
		$method = "allinpay.yunst.memberService.applyBindBankCard";
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}
	/**
	 * [createMember 创建会员]
	 */
	public function createMember($bizUserId, $memberType = 3, $source = 2)
	{
		$param = array();
		$param["bizUserId"] = $bizUserId;
		$param["memberType"] = $memberType;
		$param["source"] = $source;
		$method = "allinpay.yunst.memberService.createMember";
		$yunClient = new yunClient();
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}

	/**
	 * [setCompanyInfo 设置企业信息]
	 */
	public function setCompanyInfo($bizUserId)
	{
		$yunClient = new yunClient();
		$param = array();
		$param["bizUserId"] = $bizUserId;
		$param["backUrl"] = "https://www.baidu.com";
		$companyBasicInfo['companyName'] = '测试';
		$companyBasicInfo['legalName'] = '测试';
		$companyBasicInfo['identityType'] = 1;
		$companyBasicInfo['legalIds'] = $yunClient->encryptAES('140724199411111111');
		$companyBasicInfo['legalPhone'] = '18734893146';
		$companyBasicInfo['accountNo'] = $yunClient->encryptAES('6227000267060250071');
		$companyBasicInfo['parentBankName'] = '建设银行';
		$companyBasicInfo['businessLicense'] = '123456789';
		$companyBasicInfo['organizationCode'] = '123456789';
		$companyBasicInfo['taxRegister'] = '123456789';
		$param["companyBasicInfo"] = $companyBasicInfo;
		$param["isAuth"] = false;
		$method = "allinpay.yunst.memberService.setCompanyInfo";
		
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}	

	/**
	 * [sendVerificationCode 发送短信验证码]
	 */
	public function sendVerificationCode($bizUserId, $phone, $verificationCodeType)
	{
		$param = array();
		$param["bizUserId"] = $bizUserId;
		$param["phone"] = $phone;
		$param["verificationCodeType"] = $verificationCodeType;
		$method = "allinpay.yunst.memberService.sendVerificationCode";
		$yunClient = new yunClient();
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}

	/**
	 * [bindPhone 绑定手机]
	 */
	public function bindPhone($bizUserId, $phone, $verificationCode)
	{
		$param = array();
		$param["bizUserId"] = $bizUserId;
		$param["phone"] = $phone;
		$param["verificationCode"] = $verificationCode;
		$method = "allinpay.yunst.memberService.bindPhone";
		$yunClient = new yunClient();
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}

	/**
	 * [signContract 电子会员签约]
	 */
	public function signContract($bizUserId,$jumpUrl,$backUrl,$source)
	{
		$param = array();
		$param["bizUserId"] = $bizUserId;
		$param["jumpUrl"] = $jumpUrl;
		$param["backUrl"] = $backUrl;
		$param["source"] = $source;
		$method = "allinpay.yunst.memberService.signContract";
		$yunClient = new yunClient();
		$result = $yunClient->concatUrlParams($method,$param);
		$url = "http://test.allinpay.com/op/gateway?".$result;
		$this->logIns->logMessage("[电子会员签约URL]",Log::INFO,$url);
		header("Location:$url");
	}

	public function signBalanceProtocol($bizUserId,$jumpUrl,$backUrl,$source=2)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["protocolReqSn"] = "TL".date("Ymdhis");
		$param["payerId"] = $bizUserId;
		$param["receiverId"] = "#yunBizUserId_B2C#";
		$param["protocolName"] = "平台测试";
		$param["jumpUrl"] = $jumpUrl;
		$param["backUrl"] = $yunClient->encryptAES($backUrl);
		$param["source"] = $source;
		$method = "allinpay.yunst.memberService.signBalanceProtocol";
		
		$result = $yunClient->concatUrlParams($method,$param);
		$url = "http://test.allinpay.com/op/gateway?".$result;
		$this->logIns->logMessage("[协议扣款URL]",Log::INFO,$url);
		header("Location:$url");
	}	

	/**
	 * [setRealName 实名认证]
	 */
	public function setRealName($bizUserId,$name,$identityNo)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$param["name"] = $name;
		$param["identityType"] = "1";
		$param["identityNo"] = $yunClient->encryptAES($identityNo);
		$method = "allinpay.yunst.memberService.setRealName";
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}

	/**
	 * [getMemberInfo 获取会员信息]
	 * @param  [type] $bizUserId [description]
	 * @return [type]            [description]
	 */
	public function getMemberInfo($bizUserId)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = (string)$bizUserId;
		$method = "allinpay.yunst.memberService.getMemberInfo";
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}

	/**
	 * [getBankCardBin 查询卡bin]
	 */
	public function getBankCardBin($cardNo)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["cardNo"] = $yunClient->encryptAES($cardNo);
		$method = "allinpay.yunst.memberService.getBankCardBin";
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}

	/**
	 * [applyBindBankCard 申请绑卡]
	 */


	/**
	 * [applyBindBankCard 确认绑定银行卡]
	 */
	public function bindBankCard($bizUserId,$tranceNum,$phone,$verificationCode,$validate=null,$cvv2=null)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$param["tranceNum"] = $tranceNum;
		$param["phone"] = $phone;
		$param["verificationCode"] = $verificationCode;
		$param["validate"] = $yunClient->encryptAES($validate);
		$param["cvv2"] = $yunClient->encryptAES($cvv2);
		$method = "allinpay.yunst.memberService.bindBankCard";
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}

	/**
	 * [queryBankCard 查询绑定银行卡]
	 */
	public function queryBankCard($bizUserId)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$method = "allinpay.yunst.memberService.queryBankCard";
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}

	/**
	 * [unbindBankCard 解绑绑定银行卡]
	 */
	public function unbindBankCard($bizUserId,$cardNo)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$param["cardNo"] = $yunClient->encryptAES($cardNo);
		$method = "allinpay.yunst.memberService.unbindBankCard";
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}

	/**
	 * [lockMember 锁定会员]
	 */
	public function lockMember($bizUserId)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$method = "allinpay.yunst.memberService.lockMember";
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}

	/**
	 * [lockMember 解锁会员]
	 */
	public function unlockMember($bizUserId)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$method = "allinpay.yunst.memberService.unlockMember";
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}

	/**
	 * [setPayPwd 设置支付密码【密码验证版】]
	 */
	public function setPayPwd($bizUserId,$phone,$identityType,$identityNo,$jumpUrl,$backUrl,$name)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$param["phone"] = $phone;
		$param["name"] = $name;
		$param["identityType"] = $identityType;
		$param["identityNo"] = $yunClient->encryptAES($identityNo);
		$param["jumpUrl"] = $jumpUrl;
		$param["backUrl"] = $backUrl;
		$method = "allinpay.yunst.memberService.setPayPwd";
		$result = $yunClient->concatUrlParams($method,$param);
		$url = "http://test.allinpay.com/op/gateway?".$result;
		$this->logIns->logMessage("[设置支付密码【密码验证版】]",Log::INFO,$url);
		header("Location:$url");
	}

	/**
	 * [updatePayPwd 修改支付密码【密码验证版】]
	 */
	public function updatePayPwd($bizUserId,$name,$identityType,$identityNo,$jumpUrl,$backUrl)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$param["name"] = $name;
		$param["identityType"] = $identityType;
		$param["identityNo"] = $yunClient->encryptAES($identityNo);
		$param["jumpUrl"] = $jumpUrl;
		$param["backUrl"] = $backUrl;
		$method = "allinpay.yunst.memberService.updatePayPwd";
		$result = $yunClient->concatUrlParams($method,$param);
		$url = "http://test.allinpay.com/op/gateway?".$result;
		$this->logIns->logMessage("[修改支付密码【密码验证版】]",Log::INFO,$url);
		header("Location:$url");
	}

	/**
	 * [resetPayPwd 重置支付密码【密码验证版】]
	 */
	public function resetPayPwd($bizUserId,$name,$phone,$identityType,$identityNo,$jumpUrl,$backUrl)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$param["name"] = $name;
		$param["phone"] = $phone;
		$param["identityType"] = $identityType;
		$param["identityNo"] = $yunClient->encryptAES($identityNo);
		$param["jumpUrl"] = $jumpUrl;
		$param["backUrl"] = $backUrl;
		$method = "allinpay.yunst.memberService.resetPayPwd";
		$result = $yunClient->concatUrlParams($method,$param);
		$url = "http://test.allinpay.com/op/gateway?".$result;
		$this->logIns->logMessage("[重置支付密码【密码验证版】]",Log::INFO,$url);
		header("Location:$url");
	}

	/**
	 * [updatePhoneByPayPwd 修改绑定手机【密码验证版】]
	 */
	public function updatePhoneByPayPwd($bizUserId,$name,$oldphone,$identityType,$identityNo,$jumpUrl,$backUrl)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$param["name"] = $name;
		$param["oldPhone"] = $oldPhone;
		$param["identityType"] = $identityType;
		$param["identityNo"] = $yunClient->encryptAES($identityNo);
		$param["jumpUrl"] = $jumpUrl;
		$param["backUrl"] = $backUrl;
		$method = "allinpay.yunst.memberService.updatePhoneByPayPwd";
		$result = $yunClient->concatUrlParams($method,$param);
		$url = "http://test.allinpay.com/op/gateway?".$result;
		$this->logIns->logMessage("[修改绑定手机【密码验证版】]",Log::INFO,$url);
		header("Location:$url");
	}

	/**
	 * [applyBindAcct 会员绑定支付账户用户标识]
	 */
	public function applyBindAcct($bizUserId,$operationType,$acctType,$acct)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$param["operationType"] = $operationType;
		$param["acctType"] = $acctType;
		$param["acct"] = $acct;
		$method = "allinpay.yunst.memberService.applyBindAcct";
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}

	/**
	 * [unbindPhone 解绑手机（验证原手机短信验证码）]
	 */
	public function unbindPhone($bizUserId,$phone,$verificationCode)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$param["phone"] = $phone;
		$param["verificationCode"] = $verificationCode;
		$method = "allinpay.yunst.memberService.unbindPhone";
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}

	/**
	 * [testdecryptAES 测试AES解密]
	 */
	public function testdecryptAES($string)
	{
		$yunClient = new yunClient();
		$result = $yunClient->decryptAES($string);
		var_dump($result);
	}


	public function filebase()
	{
		$file = "data/2222.png";
		$base64_data = base64_encode(file_get_contents($file));
		// $md5file = md5_file($file);
		// var_dump($base64_data);
		// var_dump($md5file);
		return $base64_data;
	}

	public function idcardCollect($bizUserId)
	{
		$param = array();
		$yunClient = new yunClient();
		$param["bizUserId"] = $bizUserId;
		$param["picType"] = 1;
		$param["picture"] = $this->filebase();
		$method = "allinpay.yunst.memberService.idcardCollect";
		$result = $yunClient->request($method,$param);
		var_dump($result);
	}	
}
