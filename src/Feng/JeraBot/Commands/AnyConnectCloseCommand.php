<?php
/*
	Copyright (c) 2016, Zhaofeng Li
	All rights reserved.
	Redistribution and use in source and binary forms, with or without
	modification, are permitted provided that the following conditions are met:
	* Redistributions of source code must retain the above copyright notice, this
	list of conditions and the following disclaimer.
	* Redistributions in binary form must reproduce the above copyright notice,
	this list of conditions and the following disclaimer in the documentation
	and/or other materials provided with the distribution.
	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
	AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
	IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
	DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
	FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
	DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
	SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
	CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
	OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
	OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

namespace Feng\JeraBot\Commands;

use Telegram\Bot\Actions;
use Feng\JeraBot\Command;
use Feng\JeraBot\Access;
use Feng\JeraBot\FindEngine;

class AnyConnectCloseCommand extends Command {
	protected $name = "anyconnectclose";

	protected $description = "关闭权限设置";

	protected $access = Access::ADMIN;

	/*protected $find = null;*/

	public function init() {
		$this->find = new FindEngine( "user", $this );
	}

	public function initOptions() {
		$this->find->attachOptions();
	}

	public function handle( $arguments ) {
		try {
			$results = $this->find->runQuery();
		} catch ( \Exception $e ) {
			$this->replyWithMessage( array(
		"text" => "出错了\xF0\x9F\x8C\x9A " . $e->getMessage()
			) );
			return;
		}
		if ( !$results || 0 === $results->count() ) {
			$this->replyWithMessage( array(
				"text" => "并没有找到符合要求的用户"
			) );
			return;
		}
		$users = $this->find->runQuery();
		$bridge = $this->find->getPanelBridge();
			foreach ( $results as $user ) {
		if ( $user->ac_enable ) {
			$user->ac_enable = 0;
			$user->ac_user_name = "";
			$user->ac_passwd = "";
			$user->save();
			$username = $user->user_name;
		}else{
			$this->replyWithMessage( array(
				"text" => "用户未开通服务"
		) );
			return;
		}
			}
		$template_fail = <<<EOF
失败：用户端口为'%s'
请尝试在面板手动关闭。
[点击跳转](dogespeed.ga/admin)
EOF;

		if (  $user->ac_enable === 1 ) {
		$respond_fail  = sprintf(
				$template_fail,
				$user->port
				);	

		$this->replyWithMessage( array(
			"text" => $response_fail,
			"parse_mode" => "Markdown"
		) );

		} else {

		$template_success = <<<EOF
*关闭成功！信息如下*
关闭用户：'%s'
[管理平台](https://dogespeed.ga/user/）
EOF;
		$respond_success = sprintf(
				$template_success,
				$username
		);
		$this->replyWithMessage( array(
		 	"text" => $respond_success,
			"parse_mode" => "Markdown"
		) );
	}	
			}

	}
