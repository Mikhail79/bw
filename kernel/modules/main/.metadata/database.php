<?
/**
 * BlueWhale PHP Framework
 *
 * @version 0.1.2 alpha (31.12.2017)
 * @author Mikhail Shershnyov <useful-soft@yandex.ru>
 * @copyright Copyright (C) 2006-2017 Mikhail Shershnyov. All rights reserved.
 * @link https://bwframework.ru
 * @license The MIT License https://bwframework.ru/license/
 */

$tables[] = [
	'name' => 'antiflood',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'varchar',
			'length' => '50',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uid',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'expiry',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'type_ip',
			'type' => 'index',
			'fields' => [
				'type',
				'ip',
			],
		],
		[
			'name' => 'ip',
			'type' => 'index',
			'fields' => [
				'ip',
			],
		],
		[
			'name' => 'ts',
			'type' => 'index',
			'fields' => [
				'ts',
			],
		],
		[
			'name' => 'expiry',
			'type' => 'index',
			'fields' => [
				'expiry',
			],
		],
		[
			'name' => 'type',
			'type' => 'index',
			'fields' => [
				'type',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
		[
			'name' => 'application',
			'type' => 'index',
			'fields' => [
				'application',
				'uid',
			],
		],
	],
];


$tables[] = [
	'name' => 'banned_ip',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'varbinary',
			'length' => '16',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'reason',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'auto',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Авто или ручная блокировка.',
			'enums' => [
			],
		],
		[
			'name' => 'term',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
		[
			'name' => 'ip',
			'type' => 'index',
			'fields' => [
				'ip',
			],
		],
	],
];


$tables[] = [
	'name' => 'blocks',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'title',
			'type' => 'tinytext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'file',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'template',
			'type' => 'tinytext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'app',
			'type' => 'varchar',
			'length' => '50',
			'default' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'content',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'app',
			'type' => 'index',
			'fields' => [
				'app',
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'index',
			'fields' => [
				'create_ts',
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'index',
			'fields' => [
				'update_ts',
			],
		],
		[
			'name' => 'active',
			'type' => 'index',
			'fields' => [
				'active',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
		[
			'name' => 'name',
			'type' => 'index',
			'fields' => [
				'name',
			],
		],
	],
];


$tables[] = [
	'name' => 'block_positions',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'app_name',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'interface_name',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'file',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'block_position',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'block_name',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'comments',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'inner_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'text',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'level',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'left_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'right_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'email',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'check_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'score',
			'type' => 'int',
			'length' => '11',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'inner_id',
			'type' => 'unique',
			'fields' => [
				'inner_id',
				'record_id',
				'record_type',
			],
		],
		[
			'name' => 'user_id',
			'type' => 'index',
			'fields' => [
				'user_id',
			],
		],
		[
			'name' => 'record_type',
			'type' => 'index',
			'fields' => [
				'record_type',
			],
		],
		[
			'name' => 'record_id',
			'type' => 'index',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'level',
			'type' => 'index',
			'fields' => [
				'level',
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'index',
			'fields' => [
				'parent_id',
			],
		],
		[
			'name' => 'root_id',
			'type' => 'index',
			'fields' => [
				'root_id',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'index',
			'fields' => [
				'create_ts',
			],
		],
		[
			'name' => 'left_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'left_id',
			],
		],
		[
			'name' => 'right_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'right_id',
			],
		],
		[
			'name' => 'application',
			'type' => 'index',
			'fields' => [
				'application',
			],
		],
	],
];


$tables[] = [
	'name' => 'comments_vote',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'comment_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'inner_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'plus',
				'minus',
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'type',
			'type' => 'index',
			'fields' => [
				'type',
			],
		],
	],
];


$tables[] = [
	'name' => 'contact_form',
	'comment' => '',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'read_ts',
			'type' => 'int',
			'length' => '11',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'subject',
			'type' => 'varchar',
			'length' => '200',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'message',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'varbinary',
			'length' => '16',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'email',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'read_ts',
			'type' => 'index',
			'fields' => [
				'read_ts',
			],
		],
	],
];


$tables[] = [
	'name' => 'content_type',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset',
	'comment' => '',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'synonym',
			'type' => 'tinytext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter1',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter2',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter3',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter4',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter5',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter6',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter7',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter8',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'main_field_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'handler',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'tree_view',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'page_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'file_storage',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ajax',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Адрес набора данных.',
			'enums' => [
			],
		],
		[
			'name' => 'revision',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Версионировать данные.',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'name',
			'type' => 'index',
			'fields' => [
				'name',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_17_extra',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'string_value',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'integer_value',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uinteger_value',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'float_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ufloat_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'date_value',
			'type' => 'datetime',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'record_id',
				'field_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_17_list',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'common_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'language_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '10',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'tags',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_title',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_keywords',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_h1',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'content',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parents',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'links',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'varchar',
			'length' => '1024',
			'default' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_url_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_643',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'common_id',
				'language_id',
			],
		],
		[
			'name' => 'index2',
			'type' => 'index',
			'fields' => [
				'type',
				'structure_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_17_tree',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'left_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'right_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'level',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter1',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter2',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter3',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter4',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter5',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter6',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter7',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter8',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'index',
			'fields' => [
				'parent_id',
			],
		],
		[
			'name' => 'left_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'left_id',
			],
		],
		[
			'name' => 'right_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'right_id',
			],
		],
		[
			'name' => 'record_type',
			'type' => 'index',
			'fields' => [
				'record_type',
			],
		],
		[
			'name' => 'record_id',
			'type' => 'index',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'url_id',
			'type' => 'index',
			'fields' => [
				'url_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_18_extra',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'string_value',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'integer_value',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uinteger_value',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'float_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ufloat_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'date_value',
			'type' => 'datetime',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'record_id',
				'field_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_18_list',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'common_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'language_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '10',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'tags',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_title',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_keywords',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_h1',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'content',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parents',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'links',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'varchar',
			'length' => '1024',
			'default' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_url_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_681',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_682',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_721',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_722',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_723',
			'type' => 'date',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_724',
			'type' => 'tinyint',
			'length' => '1',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'common_id',
				'language_id',
			],
		],
		[
			'name' => 'index2',
			'type' => 'index',
			'fields' => [
				'type',
				'structure_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_18_tree',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'left_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'right_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'level',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter1',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter2',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter3',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter4',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter5',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter6',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter7',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter8',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'index',
			'fields' => [
				'parent_id',
			],
		],
		[
			'name' => 'left_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'left_id',
			],
		],
		[
			'name' => 'right_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'right_id',
			],
		],
		[
			'name' => 'record_type',
			'type' => 'index',
			'fields' => [
				'record_type',
			],
		],
		[
			'name' => 'record_id',
			'type' => 'index',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'url_id',
			'type' => 'index',
			'fields' => [
				'url_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_19_extra',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'string_value',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'integer_value',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uinteger_value',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'float_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ufloat_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'date_value',
			'type' => 'datetime',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'record_id',
				'field_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_19_list',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'common_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'language_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '10',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'tags',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_title',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_keywords',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_h1',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'content',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parents',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'links',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'varchar',
			'length' => '1024',
			'default' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_url_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_720',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'common_id',
				'language_id',
			],
		],
		[
			'name' => 'index2',
			'type' => 'index',
			'fields' => [
				'type',
				'structure_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_19_tree',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'left_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'right_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'level',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter1',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter2',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter3',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter4',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter5',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter6',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter7',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter8',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'index',
			'fields' => [
				'parent_id',
			],
		],
		[
			'name' => 'left_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'left_id',
			],
		],
		[
			'name' => 'right_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'right_id',
			],
		],
		[
			'name' => 'record_type',
			'type' => 'index',
			'fields' => [
				'record_type',
			],
		],
		[
			'name' => 'record_id',
			'type' => 'index',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'url_id',
			'type' => 'index',
			'fields' => [
				'url_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_20_extra',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'string_value',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'integer_value',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uinteger_value',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'float_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ufloat_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'date_value',
			'type' => 'datetime',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'record_id',
				'field_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_20_list',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'common_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'language_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '10',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'tags',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_title',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_keywords',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_h1',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'content',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parents',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'links',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'varchar',
			'length' => '1024',
			'default' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_url_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'common_id',
				'language_id',
			],
		],
		[
			'name' => 'index2',
			'type' => 'index',
			'fields' => [
				'type',
				'structure_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_20_tree',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'left_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'right_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'level',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter1',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter2',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter3',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter4',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter5',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter6',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter7',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter8',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'index',
			'fields' => [
				'parent_id',
			],
		],
		[
			'name' => 'left_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'left_id',
			],
		],
		[
			'name' => 'right_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'right_id',
			],
		],
		[
			'name' => 'record_type',
			'type' => 'index',
			'fields' => [
				'record_type',
			],
		],
		[
			'name' => 'record_id',
			'type' => 'index',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'url_id',
			'type' => 'index',
			'fields' => [
				'url_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_21_extra',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'string_value',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'integer_value',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uinteger_value',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'float_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ufloat_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'date_value',
			'type' => 'datetime',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'record_id',
				'field_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_21_list',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'common_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'language_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '10',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'tags',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_title',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_keywords',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_h1',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'content',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parents',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'links',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'varchar',
			'length' => '1024',
			'default' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_url_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_799',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_800',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'common_id',
				'language_id',
			],
		],
		[
			'name' => 'index2',
			'type' => 'index',
			'fields' => [
				'type',
				'structure_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_21_tree',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'left_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'right_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'level',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter1',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter2',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter3',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter4',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter5',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter6',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter7',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter8',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'index',
			'fields' => [
				'parent_id',
			],
		],
		[
			'name' => 'left_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'left_id',
			],
		],
		[
			'name' => 'right_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'right_id',
			],
		],
		[
			'name' => 'record_type',
			'type' => 'index',
			'fields' => [
				'record_type',
			],
		],
		[
			'name' => 'record_id',
			'type' => 'index',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'url_id',
			'type' => 'index',
			'fields' => [
				'url_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_22_extra',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'string_value',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'integer_value',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uinteger_value',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'float_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ufloat_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'date_value',
			'type' => 'datetime',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'record_id',
				'field_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_22_list',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'common_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'language_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '10',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'tags',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_title',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_keywords',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_h1',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'content',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parents',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'links',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'varchar',
			'length' => '1024',
			'default' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_url_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_838',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'common_id',
				'language_id',
			],
		],
		[
			'name' => 'index2',
			'type' => 'index',
			'fields' => [
				'type',
				'structure_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_22_tree',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'left_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'right_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'level',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter1',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter2',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter3',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter4',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter5',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter6',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter7',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter8',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'index',
			'fields' => [
				'parent_id',
			],
		],
		[
			'name' => 'left_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'left_id',
			],
		],
		[
			'name' => 'right_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'right_id',
			],
		],
		[
			'name' => 'record_type',
			'type' => 'index',
			'fields' => [
				'record_type',
			],
		],
		[
			'name' => 'record_id',
			'type' => 'index',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'url_id',
			'type' => 'index',
			'fields' => [
				'url_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_23_extra',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'string_value',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'integer_value',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uinteger_value',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'float_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ufloat_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'date_value',
			'type' => 'datetime',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'record_id',
				'field_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_23_list',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'common_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'language_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '10',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'tags',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_title',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_keywords',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_h1',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'content',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parents',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'links',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'varchar',
			'length' => '1024',
			'default' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_url_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_876',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_877',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_878',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_879',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_880',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'common_id',
				'language_id',
			],
		],
		[
			'name' => 'index2',
			'type' => 'index',
			'fields' => [
				'type',
				'structure_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_23_tree',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'left_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'right_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'level',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter1',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter2',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter3',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter4',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter5',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter6',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter7',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter8',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'index',
			'fields' => [
				'parent_id',
			],
		],
		[
			'name' => 'left_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'left_id',
			],
		],
		[
			'name' => 'right_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'right_id',
			],
		],
		[
			'name' => 'record_type',
			'type' => 'index',
			'fields' => [
				'record_type',
			],
		],
		[
			'name' => 'record_id',
			'type' => 'index',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'url_id',
			'type' => 'index',
			'fields' => [
				'url_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_24_extra',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'string_value',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'integer_value',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uinteger_value',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'float_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ufloat_value',
			'type' => 'float',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'date_value',
			'type' => 'datetime',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'record_id',
				'field_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_24_list',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'common_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'language_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '10',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'tags',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_title',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_keywords',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_h1',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'content',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parents',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'links',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'varchar',
			'length' => '1024',
			'default' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_url_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_918',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'index1',
			'type' => 'index',
			'fields' => [
				'common_id',
				'language_id',
			],
		],
		[
			'name' => 'index2',
			'type' => 'index',
			'fields' => [
				'type',
				'structure_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_24_tree',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'left_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'right_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'group',
				'item',
			],
		],
		[
			'name' => 'level',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter1',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter2',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter3',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter4',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter5',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter6',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter7',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'counter8',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'index',
			'fields' => [
				'parent_id',
			],
		],
		[
			'name' => 'left_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'left_id',
			],
		],
		[
			'name' => 'right_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'right_id',
			],
		],
		[
			'name' => 'record_type',
			'type' => 'index',
			'fields' => [
				'record_type',
			],
		],
		[
			'name' => 'record_id',
			'type' => 'index',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'url_id',
			'type' => 'index',
			'fields' => [
				'url_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_field',
	'comment' => '',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Если 0, тогда поле общее.',
			'enums' => [
			],
		],
		[
			'name' => 'field_name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Имя поля в базе данных.',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Символьный код поля, по которому происходит обращение в методе $ds->field()',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'synonym',
			'type' => 'tinytext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Тип данных PHP.',
			'enums' => [
				'string',
				'integer',
				'boolean',
				'float',
				'array',
			],
		],
		[
			'name' => 'array',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'read_only',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'subtype_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Внутренний код подтипа данных MySQL.',
			'enums' => [
			],
		],
		[
			'name' => 'type_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Внутренний код типа данных MySQL.',
			'enums' => [
			],
		],
		[
			'name' => 'm',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Длина MySQL.',
			'enums' => [
			],
		],
		[
			'name' => 'entity',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'field',
				'list_field',
				'tree_field',
			],
		],
		[
			'name' => 'slave_dataset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Набор данных - источник значений.',
			'enums' => [
			],
		],
		[
			'name' => 'view_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Тип элемента управления.',
			'enums' => [
			],
		],
		[
			'name' => 'view',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Дополнительный тип поля.',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'multiple',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Для листбокса и файла.',
			'enums' => [
			],
		],
		[
			'name' => 'key_data_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Тип данных значения (ключа). 0 - string, 1 - integer, 2 - float',
			'enums' => [
			],
		],
		[
			'name' => 'date_format',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'searchable',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'save_original_file_name',
			'type' => 'int',
			'length' => '1',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Сохранять оригинальное имя файла на диске.',
			'enums' => [
			],
		],
		[
			'name' => 'upload_dir',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Директория для загрузки файлов. Переопределяет ту, что указана в наборе.',
			'enums' => [
			],
		],
		[
			'name' => 'image_handler',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'main_image_handler',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'secondary_image_handler',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_form',
	'comment' => 'Свойства форм.',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'tab_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'fieldset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'required',
			'type' => 'int',
			'length' => '1',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Обязательное для заполнения поле.',
			'enums' => [
			],
		],
		[
			'name' => 'synonym',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'wide',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'visible',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'format',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'view',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Устаревшее поле. Используется view_type из dataset_field',
			'enums' => [
			],
		],
		[
			'name' => 'rows',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'editor',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'width',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'height',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'group',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'editable',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'expander',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'image_handler',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'main_image_handler',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'secondary_image_handler',
			'type' => 'int',
			'length' => '11',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'file_multi_upload',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'visible_condition',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '0 - показывать поле всегда, 1 - показывать только для новой записи, 2 - показывать только для существующей записи.',
			'enums' => [
			],
		],
		[
			'name' => 'default_value',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'multi',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'main_index',
			'type' => 'unique',
			'fields' => [
				'dataset_id',
				'structure_id',
				'field_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_form_fieldset',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'tab_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_form_tab',
	'comment' => 'Вкладки в формах.',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'main',
			'type' => 'index',
			'fields' => [
				'dataset_id',
				'structure_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_list',
	'comment' => 'Свойства списковой (табличной) части.',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'align',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'valign',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'column_width',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'length',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'width',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'height',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'view',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'group',
			'type' => 'int',
			'length' => '11',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'synonym',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'editable',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sortable',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'format',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'decorator',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uploader_type',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'no_image',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'alignment',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'visible',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'main_index',
			'type' => 'unique',
			'fields' => [
				'dataset_id',
				'structure_id',
				'field_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dataset_structure',
	'comment' => '',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'item',
				'group',
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'synonym',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url_pattern',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'without_url',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'request_data',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Дополнение к url_pattern.',
			'enums' => [
			],
		],
		[
			'name' => 'inherit_list',
			'type' => 'int',
			'length' => '1',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Наследование настроек от основного списка. Если 1 - значит используется настройка основного списка, если 0 - значит структура имеет собственную настройку списка.',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dictionary',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'str_id',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'main_language_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'completeness',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Завершённость перевода, среднее по всем словам.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dictionary_language',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dictionary_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'language_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'main',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dictionary_word',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dictionary_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'hash',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'is_group',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'left_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'right_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'level',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'completeness',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Завершённость перевода.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'dictionary_word_translation',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'word_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dictionary_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'language_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'value',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'hash',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'hash',
			'type' => 'index',
			'fields' => [
				'hash',
			],
		],
	],
];


$tables[] = [
	'name' => 'ds_files',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'file_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'main',
			'type' => 'int',
			'length' => '1',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'main',
			'type' => 'index',
			'fields' => [
				'dataset_id',
				'record_id',
				'field_id',
				'file_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'entities',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'files',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'inner_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'token',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uid',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sid',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Символьный код сессии, служит для поиска файлов по сессии, обнуляется, когда задан uid.',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'original_name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'size',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'info',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'status',
			'type' => 'int',
			'length' => '10',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'check_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'tmp',
			'type' => 'int',
			'length' => '1',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'hash',
			'type' => 'varchar',
			'length' => '40',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'mime',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'width',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'height',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sub_dir',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Поддиректория относительно директории uploads.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'inner_id',
			'type' => 'index',
			'fields' => [
				'inner_id',
				'token',
			],
		],
		[
			'name' => 'hash',
			'type' => 'index',
			'fields' => [
				'hash',
			],
		],
	],
];


$tables[] = [
	'name' => 'forums',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'forum_messages',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'forum_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'topic_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'author_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'author_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'title',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'message',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'forum_id',
			'type' => 'index',
			'fields' => [
				'forum_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'forum_topics',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'forum_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'message_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'author_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'author_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'cnt_views',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'cnt_replies',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'last_message_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'important',
			'type' => 'int',
			'length' => '1',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'closed',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'forum_id',
			'type' => 'index',
			'fields' => [
				'forum_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'forum_users',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'profile_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'forum_user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'forum_views',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'author_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'author_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'topic_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'groups',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'module_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'tinytext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'system',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'app_name',
			'type' => 'unique',
			'fields' => [
				'application',
				'name',
			],
		],
		[
			'name' => 'application',
			'type' => 'index',
			'fields' => [
				'application',
			],
		],
		[
			'name' => 'name',
			'type' => 'index',
			'fields' => [
				'name',
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'index',
			'fields' => [
				'create_ts',
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'index',
			'fields' => [
				'update_ts',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
	],
];


$tables[] = [
	'name' => 'image_handler',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'width',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'height',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'crop',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'watermark',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'watermark_path',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'save_path',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'save_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'orientation',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'interface_blocks',
	'comment' => '',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'bid',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'interface',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'template',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'app',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'position',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'invitation',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ticket',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Пригласительный билет.',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Дата создания приглашения.',
			'enums' => [
			],
		],
		[
			'name' => 'recipient_email',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'E-mail получателя.',
			'enums' => [
			],
		],
		[
			'name' => 'recipient_reg_ts',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Дата регистрация получателя.',
			'enums' => [
			],
		],
		[
			'name' => 'sender_id',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Код отправителя.',
			'enums' => [
			],
		],
		[
			'name' => 'send_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Дата отправки.',
			'enums' => [
			],
		],
		[
			'name' => 'recipient_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Код получателя.',
			'enums' => [
			],
		],
		[
			'name' => 'invalid',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'recipient_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Группа пользователя.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'ticket',
			'type' => 'index',
			'fields' => [
				'ticket',
			],
		],
	],
];


$tables[] = [
	'name' => 'invitation_registration',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'token',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'invitation_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'token',
			'type' => 'unique',
			'fields' => [
				'token',
			],
		],
	],
];


$tables[] = [
	'name' => 'keys',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'expiry',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'key',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'key',
			'type' => 'unique',
			'fields' => [
				'key',
			],
		],
		[
			'name' => 'ts',
			'type' => 'index',
			'fields' => [
				'ts',
			],
		],
		[
			'name' => 'expiry',
			'type' => 'index',
			'fields' => [
				'expiry',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
	],
];


$tables[] = [
	'name' => 'kladr',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'socr',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'varchar',
			'length' => '13',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'index',
			'type' => 'varchar',
			'length' => '6',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'gninmb',
			'type' => 'varchar',
			'length' => '4',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uno',
			'type' => 'varchar',
			'length' => '4',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ocatd',
			'type' => 'varchar',
			'length' => '11',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'status',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'code',
			'type' => 'index',
			'fields' => [
				'code',
			],
		],
	],
];


$tables[] = [
	'name' => 'kladr_street',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'socr',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'varchar',
			'length' => '17',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => '_index',
			'type' => 'varchar',
			'length' => '6',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'gninmb',
			'type' => 'varchar',
			'length' => '4',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uno',
			'type' => 'varchar',
			'length' => '4',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ocatd',
			'type' => 'varchar',
			'length' => '11',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'socr_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'languages',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'lid',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'flag',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'locale',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'time_format',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'date_format',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'lid',
			'type' => 'index',
			'fields' => [
				'lid',
			],
		],
	],
];


$tables[] = [
	'name' => 'log',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'varbinary',
			'length' => '16',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'event_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'event_text',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'event_data',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Адрес события.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'application',
			'type' => 'index',
			'fields' => [
				'application',
			],
		],
	],
];


$tables[] = [
	'name' => 'log_event',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'str_id',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'module_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'mailbox_addressbook',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'group_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'iblock_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'element_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'city',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'mailbox_attachment',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'message_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'file_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'owner_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'owner_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'upload_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'varbinary',
			'length' => '16',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'owner',
			'type' => 'index',
			'fields' => [
				'owner_id',
				'owner_type',
			],
		],
	],
];


$tables[] = [
	'name' => 'mailbox_message',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'copy_message_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sender_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'recipient_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sender_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'recipient_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'mass_mailing',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'folder',
			'type' => 'enum',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
				'inbox',
				'trash',
				'drafts',
				'outbox',
			],
		],
		[
			'name' => 'sent_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'read_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'subject',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'body',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sender_ip',
			'type' => 'varbinary',
			'length' => '16',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'owner_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'owner_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'has_reply',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'folder',
			'type' => 'index',
			'fields' => [
				'recipient_id',
				'folder',
			],
		],
	],
];


$tables[] = [
	'name' => 'mail_templates',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'str_id',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'language',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'from',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'subject',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'message',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'name',
			'type' => 'unique',
			'fields' => [
				'language',
				'name',
			],
		],
		[
			'name' => 'language',
			'type' => 'index',
			'fields' => [
				'language',
			],
		],
	],
];


$tables[] = [
	'name' => 'menu',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'title',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'name',
			'type' => 'unique',
			'fields' => [
				'application',
				'name',
			],
		],
		[
			'name' => 'application',
			'type' => 'index',
			'fields' => [
				'application',
			],
		],
	],
];


$tables[] = [
	'name' => 'menu_item',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'menu_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'left_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'right_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'level',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'text',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Текст анкора.',
			'enums' => [
			],
		],
		[
			'name' => 'title',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'link',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'group',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Если 1, тогда группа (может содержать подпункты). Если 0, тогда элемент.',
			'enums' => [
			],
		],
		[
			'name' => 'removed',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'module_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Код модуля создавшего этот элемент меню.',
			'enums' => [
			],
		],
		[
			'name' => 'sort_order',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'page_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Тип пункта меню.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'module',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'installed',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'module',
			'type' => 'unique',
			'fields' => [
				'application',
				'name',
			],
		],
		[
			'name' => 'id',
			'type' => 'unique',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'notes',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sid',
			'type' => 'char',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uid',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'int',
			'length' => '11',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'deleted',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'sid',
			'type' => 'index',
			'fields' => [
				'sid',
			],
		],
		[
			'name' => 'uid',
			'type' => 'index',
			'fields' => [
				'uid',
			],
		],
		[
			'name' => 'deleted',
			'type' => 'index',
			'fields' => [
				'deleted',
			],
		],
		[
			'name' => 'record_id',
			'type' => 'index',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'record_type',
			'type' => 'index',
			'fields' => [
				'record_type',
			],
		],
	],
];


$tables[] = [
	'name' => 'notes_files',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'file_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'note_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'file_id',
			'type' => 'index',
			'fields' => [
				'file_id',
			],
		],
		[
			'name' => 'note_id',
			'type' => 'index',
			'fields' => [
				'note_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'option',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'module_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Модуль создавший опцию.',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Приложение создавшее опцию.',
			'enums' => [
			],
		],
		[
			'name' => 'module',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Модуль создавший опцию.',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Описание опции.',
			'enums' => [
			],
		],
		[
			'name' => 'data_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Тип данных.',
			'enums' => [
			],
		],
		[
			'name' => 'view',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Вид редактора.',
			'enums' => [
			],
		],
		[
			'name' => 'default_value',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Значение по умолчанию.',
			'enums' => [
			],
		],
		[
			'name' => 'values',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Возможные значения.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'name',
			'type' => 'unique',
			'fields' => [
				'name',
			],
		],
	],
];


$tables[] = [
	'name' => 'option_value',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'option_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'value',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'pages',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'str_id',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'synonym',
			'type' => 'tinytext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'title',
			'type' => 'tinytext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'keywords',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'seo_h1',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'file',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'template',
			'type' => 'tinytext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'save_hits',
			'type' => 'int',
			'length' => '1',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Сохранять хиты (хосты, визиты, посещения) для статистики.',
			'enums' => [
			],
		],
		[
			'name' => 'breadcrumb_state',
			'type' => 'int',
			'length' => '10',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sitemap',
			'type' => 'int',
			'length' => '1',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'app',
			'type' => 'varchar',
			'length' => '50',
			'default' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url_id',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'left_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'right_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'level',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'module_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Код модуля создавшего эту страницу.',
			'enums' => [
			],
		],
		[
			'name' => 'external_call',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Источник дополнительных полей.',
			'enums' => [
			],
		],
		[
			'name' => 'breadcrumb_text',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Текст хлебной крошки.',
			'enums' => [
			],
		],
		[
			'name' => 'content',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'view_file',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Код пользователя создавшего страницу.',
			'enums' => [
			],
		],
		[
			'name' => 'user_id_update',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Код пользователя изменившего страницу.',
			'enums' => [
			],
		],
		[
			'name' => 'main_page',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'app',
			'type' => 'index',
			'fields' => [
				'app',
			],
		],
		[
			'name' => 'url_id',
			'type' => 'index',
			'fields' => [
				'url_id',
			],
		],
		[
			'name' => 'left_id',
			'type' => 'index',
			'fields' => [
				'left_id',
			],
		],
		[
			'name' => 'right_id',
			'type' => 'index',
			'fields' => [
				'right_id',
			],
		],
		[
			'name' => 'root_id',
			'type' => 'index',
			'fields' => [
				'root_id',
			],
		],
		[
			'name' => 'level',
			'type' => 'index',
			'fields' => [
				'level',
			],
		],
		[
			'name' => 'name',
			'type' => 'index',
			'fields' => [
				'name',
			],
		],
	],
];


$tables[] = [
	'name' => 'poll',
	'comment' => 'Голосования',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Активно или нет',
			'enums' => [
			],
		],
		[
			'name' => 'multi_answers',
			'type' => 'int',
			'length' => '1',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Режим "Несколько ответов"',
			'enums' => [
			],
		],
		[
			'name' => 'allow_comment',
			'type' => 'int',
			'length' => '1',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Разрешить комментарий',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'begin_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'end_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'category_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'votes',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'comments_cnt',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'allow_answers',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'active',
			'type' => 'index',
			'fields' => [
				'active',
			],
		],
		[
			'name' => 'multi_answers',
			'type' => 'index',
			'fields' => [
				'multi_answers',
			],
		],
		[
			'name' => 'allow_comment',
			'type' => 'index',
			'fields' => [
				'allow_comment',
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'index',
			'fields' => [
				'create_ts',
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'index',
			'fields' => [
				'update_ts',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
	],
];


$tables[] = [
	'name' => 'poll_answers',
	'comment' => 'Вопросы к голосованиям',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'poll_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'color',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'poll_id',
			'type' => 'index',
			'fields' => [
				'poll_id',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
	],
];


$tables[] = [
	'name' => 'poll_answers_i18n',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'poll_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'lid',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'answer',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => 'KEY',
			'type' => 'unique',
			'fields' => [
				'id',
				'lid',
			],
		],
	],
];


$tables[] = [
	'name' => 'poll_comments',
	'comment' => 'Комментарии к опросам',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'poll_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uid',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'comment',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'poll_id',
			'type' => 'index',
			'fields' => [
				'poll_id',
			],
		],
		[
			'name' => 'ip',
			'type' => 'index',
			'fields' => [
				'ip',
			],
		],
		[
			'name' => 'uid',
			'type' => 'index',
			'fields' => [
				'uid',
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'index',
			'fields' => [
				'create_ts',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
	],
];


$tables[] = [
	'name' => 'poll_i18n',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'lid',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'question',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => 'KEY',
			'type' => 'unique',
			'fields' => [
				'id',
				'lid',
			],
		],
	],
];


$tables[] = [
	'name' => 'poll_results',
	'comment' => 'Результаты голосования',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'poll_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'answer_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uid',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'poll_id',
			'type' => 'index',
			'fields' => [
				'poll_id',
			],
		],
		[
			'name' => 'answer_id',
			'type' => 'index',
			'fields' => [
				'answer_id',
			],
		],
		[
			'name' => 'ip',
			'type' => 'index',
			'fields' => [
				'ip',
			],
		],
		[
			'name' => 'uid',
			'type' => 'index',
			'fields' => [
				'uid',
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'index',
			'fields' => [
				'create_ts',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
	],
];


$tables[] = [
	'name' => 'posts',
	'comment' => 'Сообщения в обсуждениях',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'text',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'discussion_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'level',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'left_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'right_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'root_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'left_id',
			'type' => 'unique',
			'fields' => [
				'root_id',
				'left_id',
			],
		],
		[
			'name' => 'user_id',
			'type' => 'index',
			'fields' => [
				'user_id',
			],
		],
		[
			'name' => 'discussion_id',
			'type' => 'index',
			'fields' => [
				'discussion_id',
			],
		],
		[
			'name' => 'level',
			'type' => 'index',
			'fields' => [
				'level',
			],
		],
		[
			'name' => 'parent_id',
			'type' => 'index',
			'fields' => [
				'parent_id',
			],
		],
		[
			'name' => 'root_id',
			'type' => 'index',
			'fields' => [
				'root_id',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'index',
			'fields' => [
				'create_ts',
			],
		],
		[
			'name' => 'right_id',
			'type' => 'index',
			'fields' => [
				'root_id',
				'right_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'prices',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'price_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'value',
			'type' => 'double',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'current',
			'type' => 'int',
			'length' => '1',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'big',
			'type' => 'unique',
			'fields' => [
				'ts',
				'price_id',
				'record_id',
			],
		],
		[
			'name' => 'ts',
			'type' => 'index',
			'fields' => [
				'ts',
			],
		],
		[
			'name' => 'price_id',
			'type' => 'index',
			'fields' => [
				'price_id',
			],
		],
		[
			'name' => 'record_id',
			'type' => 'index',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'value',
			'type' => 'index',
			'fields' => [
				'value',
			],
		],
		[
			'name' => 'current',
			'type' => 'index',
			'fields' => [
				'current',
			],
		],
	],
];


$tables[] = [
	'name' => 'queue',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'handler',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'processed',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'start_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'finish_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'index',
			'fields' => [
				'create_ts',
			],
		],
		[
			'name' => 'type',
			'type' => 'index',
			'fields' => [
				'type',
			],
		],
		[
			'name' => 'start_ts',
			'type' => 'index',
			'fields' => [
				'start_ts',
			],
		],
		[
			'name' => 'finish_ts',
			'type' => 'index',
			'fields' => [
				'finish_ts',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
	],
];


$tables[] = [
	'name' => 'realty_calendar',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'object_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'begin_date',
			'type' => 'date',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'end_date',
			'type' => 'date',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'realty_order',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'begin_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'end_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'adults',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'children',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'email',
			'type' => 'varchar',
			'length' => '200',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '200',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'phone',
			'type' => 'varchar',
			'length' => '200',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'related_pages',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'page_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'related_page_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'revision',
	'comment' => '',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'page_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'node_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'md5_hash',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sha1_hash',
			'type' => 'varchar',
			'length' => '40',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'file',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Путь к ревизируемому файлу.',
			'enums' => [
			],
		],
		[
			'name' => 'file_path_hash',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'MD5 абсолютного пути файла.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'revision_data',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'revision_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'value',
			'type' => 'longtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'sessions',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sid',
			'type' => 'char',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uid',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'expiry',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'varbinary',
			'length' => '16',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'last_request',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'start',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'app',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'variables',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'main',
			'type' => 'unique',
			'fields' => [
				'sid',
				'app',
				'uid',
			],
		],
	],
];


$tables[] = [
	'name' => 'sessions_extra',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'session_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'varbinary',
			'length' => '16',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uid',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'begin_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'end_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'last_request_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'begin_ts',
			'type' => 'index',
			'fields' => [
				'begin_ts',
			],
		],
		[
			'name' => 'end_ts',
			'type' => 'index',
			'fields' => [
				'end_ts',
			],
		],
		[
			'name' => 'last_request_ts',
			'type' => 'index',
			'fields' => [
				'last_request_ts',
			],
		],
		[
			'name' => 'ip',
			'type' => 'index',
			'fields' => [
				'ip',
			],
		],
		[
			'name' => 'uid',
			'type' => 'index',
			'fields' => [
				'uid',
			],
		],
		[
			'name' => 'session_id',
			'type' => 'index',
			'fields' => [
				'session_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'settings',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'opt',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'value',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'opt',
			'type' => 'index',
			'fields' => [
				'opt',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_account',
	'comment' => '',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'balance',
			'type' => 'double',
			'length' => '10,2',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'available',
			'type' => 'double',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'locked',
			'type' => 'double',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'user_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_account_operation',
	'comment' => '',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'amount',
			'type' => 'double',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'operation_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'partner_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'partner_site_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'user_id',
			'type' => 'index',
			'fields' => [
				'user_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_cart',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Символьный код корзины, например wholesale, retail.',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sid',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'app',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'sid',
			'type' => 'index',
			'fields' => [
				'sid',
				'app',
				'user_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_cart_item',
	'comment' => '',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'cart_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'quantity',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'price',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'discount',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'currency_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_currency',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'iso_code',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Код валюты по ISO 4217',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'main',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'rate_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'iso_code',
			'type' => 'index',
			'fields' => [
				'iso_code',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_currency_rate',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'currency_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'value',
			'type' => 'float',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'nominal_value',
			'type' => 'float',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_delivery',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_delivery_status',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_order',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sid',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'payment_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'status_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'app_name',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'total',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Сумма заказа',
			'enums' => [
			],
		],
		[
			'name' => 'currency_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'phone',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'comment',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'email',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_postal_code',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_country',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_city',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_street',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_house',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_apartment',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_country_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_city_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_street_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_order_delivery',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'order_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'postal_code',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'country_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'city_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'street_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'country',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'city',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'street',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'house',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'apartment',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_id',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Служба доставки.',
			'enums' => [
			],
		],
		[
			'name' => 'departure_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Дата отправки.',
			'enums' => [
			],
		],
		[
			'name' => 'arrival_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Дата прибытия.',
			'enums' => [
			],
		],
		[
			'name' => 'status_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Статус доставки.',
			'enums' => [
			],
		],
		[
			'name' => 'price',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Стоимость доставки.',
			'enums' => [
			],
		],
		[
			'name' => 'price_currency_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Валюты стоимости доставки.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_order_item',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'order_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'product_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'quantity',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'price',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Цена за единицу.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_order_item_property_value',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'order_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'order_item_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Код позиции в списке заказа.',
			'enums' => [
			],
		],
		[
			'name' => 'product_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Код товара.',
			'enums' => [
			],
		],
		[
			'name' => 'product_prop_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Код свойства товара.',
			'enums' => [
			],
		],
		[
			'name' => 'product_prop_value',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Значение свойства товара.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_order_property',
	'comment' => 'Свойства заказа.',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_order_property_value',
	'comment' => 'Установленные значения свойств для заказа.',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'order_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'prop_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'prop_value',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_order_status',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_payment',
	'comment' => 'Платежи',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'amount',
			'type' => 'double',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'status',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '0 - не принят, 1 - зачислен',
			'enums' => [
			],
		],
		[
			'name' => 'system_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'yandex_invoice_id',
			'type' => 'bigint',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'yandex_payment_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'system_id',
			'type' => 'index',
			'fields' => [
				'system_id',
			],
		],
		[
			'name' => 'yandex_invoice_id',
			'type' => 'index',
			'fields' => [
				'yandex_invoice_id',
			],
		],
		[
			'name' => 'yandex_payment_type',
			'type' => 'index',
			'fields' => [
				'yandex_payment_type',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_payment_system',
	'comment' => 'Платёжные системы.',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_payment_system_application',
	'comment' => 'Подключенные платёжные системы.',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'app',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ps_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'shop_storage',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'address',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'sitemap_xml',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'app',
			'type' => 'varchar',
			'length' => '50',
			'default' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url',
			'type' => 'varchar',
			'length' => '200',
			'default' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'lastmod',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'changefreq',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'priority',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'type_id',
			'type' => 'index',
			'fields' => [
				'type_id',
			],
		],
		[
			'name' => 'app',
			'type' => 'index',
			'fields' => [
				'app',
			],
		],
		[
			'name' => 'url',
			'type' => 'index',
			'fields' => [
				'url',
			],
		],
		[
			'name' => 'active',
			'type' => 'index',
			'fields' => [
				'active',
			],
		],
	],
];


$tables[] = [
	'name' => 'sms',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'message',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'phone',
			'type' => 'varchar',
			'length' => '30',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'template_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'provider_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'cost',
			'type' => 'double',
			'length' => '10,2',
			'default' => '0.00',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'provider_response',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'sms_provider',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'str_id',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'str_id',
			'type' => 'index',
			'fields' => [
				'str_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'sms_template',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'str_id',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'message',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'recipients',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'str_id',
			'type' => 'index',
			'fields' => [
				'str_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'statistics',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sid',
			'type' => 'char',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uid',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'varbinary',
			'length' => '16',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_agent',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'sid',
			'type' => 'index',
			'fields' => [
				'sid',
			],
		],
		[
			'name' => 'uid',
			'type' => 'index',
			'fields' => [
				'uid',
			],
		],
		[
			'name' => 'ip',
			'type' => 'index',
			'fields' => [
				'ip',
			],
		],
		[
			'name' => 'app',
			'type' => 'index',
			'fields' => [
				'application',
			],
		],
	],
];


$tables[] = [
	'name' => 'structure',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'title',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'structure_data1',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_1',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_2',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_3',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_4',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_5',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'record_id',
			'type' => 'unique',
			'fields' => [
				'record_type',
				'record_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'structure_field',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'structure_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'title',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'view',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'default_value',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'required',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'values',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sort_order',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'subscription',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'content_type_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'email',
			'type' => 'varchar',
			'length' => '200',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'email',
			'type' => 'index',
			'fields' => [
				'email',
			],
		],
	],
];


$tables[] = [
	'name' => 't1',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
	],
];


$tables[] = [
	'name' => 't2',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'element_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'section_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'zzz',
			'type' => 'int',
			'length' => '11',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => 'KEY',
			'type' => 'unique',
			'fields' => [
				'zzz',
			],
		],
	],
];


$tables[] = [
	'name' => 'tag',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'cnt',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'hash',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'MD5 от поля name в нижнем регистре.',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'url_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'hash',
			'type' => 'index',
			'fields' => [
				'hash',
			],
		],
	],
];


$tables[] = [
	'name' => 'tag_record',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'tag_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'page_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'test_binary_table',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'varbinary',
			'length' => '200',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'tz_country',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'country_code',
			'type' => 'char',
			'length' => '2',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'country_name',
			'type' => 'varchar',
			'length' => '45',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => 'idx_country_code',
			'type' => 'index',
			'fields' => [
				'country_code',
			],
		],
	],
];


$tables[] = [
	'name' => 'tz_timezone',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'zone_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'abbreviation',
			'type' => 'varchar',
			'length' => '6',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'time_start',
			'type' => 'int',
			'length' => '11',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'gmt_offset',
			'type' => 'int',
			'length' => '11',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dst',
			'type' => 'char',
			'length' => '1',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => 'idx_zone_id',
			'type' => 'index',
			'fields' => [
				'zone_id',
			],
		],
		[
			'name' => 'idx_time_start',
			'type' => 'index',
			'fields' => [
				'time_start',
			],
		],
	],
];


$tables[] = [
	'name' => 'tz_zone',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'zone_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'country_code',
			'type' => 'char',
			'length' => '2',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'zone_name',
			'type' => 'varchar',
			'length' => '35',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'zone_id',
			],
		],
		[
			'name' => 'idx_zone_name',
			'type' => 'index',
			'fields' => [
				'zone_name',
			],
		],
	],
];


$tables[] = [
	'name' => 'url',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_type',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'hash',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'MD5 для поля url, без слэшей по краям и в нижнем регистре.',
			'enums' => [
			],
		],
		[
			'name' => 'url',
			'type' => 'varchar',
			'length' => '300',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'page_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'link_id',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'record_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'field_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'app',
			'type' => 'varchar',
			'length' => '50',
			'default' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'weight',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'sitemap',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'url',
			'type' => 'index',
			'fields' => [
				'url',
			],
		],
		[
			'name' => 'page_id',
			'type' => 'index',
			'fields' => [
				'page_id',
			],
		],
		[
			'name' => 'dataset_id',
			'type' => 'index',
			'fields' => [
				'dataset_id',
			],
		],
		[
			'name' => 'record_id',
			'type' => 'index',
			'fields' => [
				'record_id',
			],
		],
		[
			'name' => 'record_type',
			'type' => 'index',
			'fields' => [
				'record_type',
			],
		],
		[
			'name' => 'hash',
			'type' => 'index',
			'fields' => [
				'hash',
			],
		],
		[
			'name' => 'app',
			'type' => 'index',
			'fields' => [
				'app',
				'hash',
			],
		],
	],
];


$tables[] = [
	'name' => 'url_patterns',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'regexp',
			'type' => 'tinytext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'description',
			'type' => 'tinytext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'matches',
			'type' => 'tinytext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'tinytext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'weight',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'module_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Модуль создавший записи.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'application',
			'type' => 'index',
			'fields' => [
				'application',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'index',
			'fields' => [
				'create_ts',
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'index',
			'fields' => [
				'update_ts',
			],
		],
		[
			'name' => 'active',
			'type' => 'index',
			'fields' => [
				'active',
			],
		],
	],
];


$tables[] = [
	'name' => 'url_redirect',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'old_url',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'new_url',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'old_url_hash',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'new_url_hash',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'old_url_hash',
			'type' => 'index',
			'fields' => [
				'old_url_hash',
			],
		],
	],
];


$tables[] = [
	'name' => 'users',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'auth_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'reg_type',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '0 - стандартный (пользователь зарегистрировался самостоятельно), 1 - через соц. сеть, 2 - создано администратором',
			'enums' => [
			],
		],
		[
			'name' => 'network',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'time_zone',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'first_name',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'middle_name',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'last_name',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'avatar_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'login',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'application',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'password_hash',
			'type' => 'varchar',
			'length' => '40',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'password_update_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'password_term_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'salt',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'hashes',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'deactivation_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'email',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'reg_ip',
			'type' => 'varbinary',
			'length' => '16',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'reg_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'last_auth_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'last_ip',
			'type' => 'varbinary',
			'length' => '16',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'activation_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'activation_key_id',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'last_request_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'gender',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '0 - пол не указан, 1 - мужской, 2 - женский',
			'enums' => [
			],
		],
		[
			'name' => 'phone',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'language_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'birthday',
			'type' => 'date',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'phone_check_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'postal_code',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'city',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'street',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'house',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'firm',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'login',
			'type' => 'index',
			'fields' => [
				'login',
			],
		],
		[
			'name' => 'email',
			'type' => 'index',
			'fields' => [
				'email',
			],
		],
		[
			'name' => 'application',
			'type' => 'index',
			'fields' => [
				'application',
			],
		],
		[
			'name' => 'activation_key_id',
			'type' => 'index',
			'fields' => [
				'activation_key_id',
			],
		],
		[
			'name' => 'phone',
			'type' => 'index',
			'fields' => [
				'phone',
			],
		],
	],
];


$tables[] = [
	'name' => 'users_groups',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'uid',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'gid',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'uid',
			'type' => 'index',
			'fields' => [
				'uid',
			],
		],
		[
			'name' => 'remove_ts',
			'type' => 'index',
			'fields' => [
				'remove_ts',
			],
		],
	],
];


$tables[] = [
	'name' => 'user_network',
	'comment' => 'Привязки аккаунтов социальных сетей.',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'identity_hash',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'md5(identity)',
			'enums' => [
			],
		],
		[
			'name' => 'identity',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'network',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'identity_hash',
			'type' => 'index',
			'fields' => [
				'identity_hash',
			],
		],
	],
];


$tables[] = [
	'name' => 'user_phone_check',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'code',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'phone',
			'type' => 'varchar',
			'length' => '50',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'approve_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'varbinary',
			'length' => '16',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip_hash',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'phone',
			'type' => 'index',
			'fields' => [
				'phone',
			],
		],
	],
];


$tables[] = [
	'name' => 'user_temporary_password',
	'comment' => '',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip',
			'type' => 'varbinary',
			'length' => '16',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ip_hash',
			'type' => 'varchar',
			'length' => '32',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'password_hash',
			'type' => 'varchar',
			'length' => '40',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'password_salt',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'active',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'auth_cnt',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Счётчик авторизаций по данному паролю.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'user_id',
			'type' => 'index',
			'fields' => [
				'user_id',
			],
		],
		[
			'name' => 'ip_hash',
			'type' => 'index',
			'fields' => [
				'ip_hash',
			],
		],
	],
];


$tables[] = [
	'name' => 'vs_cities',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'vs_houses',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'street_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'city_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'number',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'forum_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'forum_id',
			'type' => 'index',
			'fields' => [
				'forum_id',
			],
		],
	],
];


$tables[] = [
	'name' => 'vs_streets',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'city_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '100',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'xt_canton',
	'comment' => '',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'full_name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'xt_district',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'xt_lang',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '11',
			'attribute' => '',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '255',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'value',
			'type' => 'varchar',
			'length' => '255',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'location',
			'type' => 'varchar',
			'length' => '255',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'xt_municipality',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'xt_orders',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'doc_code',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'user_id',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type',
			'type' => 'int',
			'length' => '11',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '2 - EFH, 3 - MFH, 1 - GFK',
			'enums' => [
			],
		],
		[
			'name' => 'object_plz_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_distance',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Длина маршрута доставки в метрах.',
			'enums' => [
			],
		],
		[
			'name' => 'cost_rental',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Стоимость аренды за вентиляторы и сушилки.',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_cost',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Стоимость доставки.',
			'enums' => [
			],
		],
		[
			'name' => 'cost_service',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'cost_total',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'cost_all_manager',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'НЕ ИСПОЛЬЗУЕТСЯ',
			'enums' => [
			],
		],
		[
			'name' => 'discount',
			'type' => 'int',
			'length' => '10',
			'default' => '0',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'comment',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Комментарий к заказу.',
			'enums' => [
			],
		],
		[
			'name' => 'is_new_comment',
			'type' => 'int',
			'length' => '5',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'is_new_comment_admin',
			'type' => 'int',
			'length' => '5',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'comment_admin',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'object_postal_code',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Соответствует plz_code. НЕ ИСПОЛЬЗУЕТСЯ',
			'enums' => [
			],
		],
		[
			'name' => 'object_street',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'object_house',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'datetime_start',
			'type' => 'datetime',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Дата начала работ.  НЕ ИСПОЛЬЗУЕТСЯ',
			'enums' => [
			],
		],
		[
			'name' => 'start_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Дата начала работ.',
			'enums' => [
			],
		],
		[
			'name' => 'datetime_end',
			'type' => 'datetime',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'datetime_considered',
			'type' => 'datetime',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'datetime_confirm_manager',
			'type' => 'datetime',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'is_confirm',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'is_confirm_manager',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'is_considered',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'is_began',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'is_ended',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'is_close',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type_close',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'type_close_datetime',
			'type' => 'datetime',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'is_pay',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'mfh_json',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'НЕ ИСПОЛЬЗУЕТСЯ',
			'enums' => [
			],
		],
		[
			'name' => 'is_view',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'is_view_admin',
			'type' => 'int',
			'length' => '5',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'is_view_discount',
			'type' => 'int',
			'length' => '11',
			'default' => '0',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_duration',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Время поездки в секундах.',
			'enums' => [
			],
		],
		[
			'name' => 'payment_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'update_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'object_description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'order_description',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Комментарий к заказу.',
			'enums' => [
			],
		],
		[
			'name' => 'dryers',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Кол-во сушилок.',
			'enums' => [
			],
		],
		[
			'name' => 'fans',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Кол-во вентиляторов.',
			'enums' => [
			],
		],
		[
			'name' => 'days',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Кол-во дней сушки.',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_first_name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Пока нигде не используется.',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_last_name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Пока нигде не используется.',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_phone',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Пока нигде не используется.',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_firm',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Пока нигде не используется.',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_street',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Пока нигде не используется.',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_house',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Пока нигде не используется.',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_index',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Пока нигде не используется.',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_city',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Пока нигде не используется.',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_gender',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Пока нигде не используется.',
			'enums' => [
			],
		],
		[
			'name' => 'payer_first_name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'payer_last_name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'payer_phone',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'payer_firm',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'payer_street',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'payer_house',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'payer_postal_code',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'payer_city',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'payer_gender',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'create_ts',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'client_first_name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Данные из таблицы users.',
			'enums' => [
			],
		],
		[
			'name' => 'client_last_name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Данные из таблицы users.',
			'enums' => [
			],
		],
		[
			'name' => 'client_phone',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Данные из таблицы users.',
			'enums' => [
			],
		],
		[
			'name' => 'client_gender',
			'type' => 'int',
			'length' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Данные из таблицы users.',
			'enums' => [
			],
		],
		[
			'name' => 'fan_price',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Сериализованный массив с ценами аренды вентиляторов.',
			'enums' => [
			],
		],
		[
			'name' => 'dryer_price',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Сериализованный массив с ценами аренды сушилок.',
			'enums' => [
			],
		],
		[
			'name' => 'delivery_price',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => 'Стоимость 1 часа доставки.',
			'enums' => [
			],
		],
		[
			'name' => 'client_firm',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Данные из таблицы users.',
			'enums' => [
			],
		],
		[
			'name' => 'client_street',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Данные из таблицы users.',
			'enums' => [
			],
		],
		[
			'name' => 'client_house',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Данные из таблицы users.',
			'enums' => [
			],
		],
		[
			'name' => 'client_postal_code',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Данные из таблицы users.',
			'enums' => [
			],
		],
		[
			'name' => 'client_city',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'Данные из таблицы users.',
			'enums' => [
			],
		],
		[
			'name' => 'data',
			'type' => 'mediumtext',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'start_month',
			'type' => 'varchar',
			'length' => '7',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => 'В каком месяце клиент хочет заказать сушку.',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
	],
];


$tables[] = [
	'name' => 'xt_plz',
	'comment' => 'Почтовые индексы.',
	'row_format' => 'COMPACT',
	'fields' => [
		[
			'name' => 'id',
			'type' => 'int',
			'length' => '11',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'plz_code',
			'type' => 'varchar',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'text',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'lat',
			'type' => 'float',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'lng',
			'type' => 'float',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'cost',
			'type' => 'float',
			'length' => '10,2',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'enabled',
			'type' => 'int',
			'length' => '1',
			'default' => '1',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'canton_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'district_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'municipality_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => 'UNSIGNED',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id',
			],
		],
		[
			'name' => 'plz_code',
			'type' => 'index',
			'fields' => [
				'plz_code',
			],
		],
	],
];


$tables[] = [
	'name' => 'xt_records_rooms',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'id_room',
			'type' => 'int',
			'length' => '11',
			'attribute' => '',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'id_record',
			'type' => 'int',
			'length' => '11',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '255',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'rooms',
			'type' => 'float',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'area',
			'type' => 'float',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'ceiling',
			'type' => 'float',
			'length' => '',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'id_room',
			],
		],
	],
];


$tables[] = [
	'name' => 'xt_settings',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'name',
			'type' => 'varchar',
			'length' => '255',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'value',
			'type' => 'varchar',
			'length' => '255',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => 'KEY',
			'type' => 'unique',
			'fields' => [
				'name',
			],
		],
	],
];


$tables[] = [
	'name' => 'zone',
	'comment' => '',
	'row_format' => '',
	'fields' => [
		[
			'name' => 'zone_id',
			'type' => 'int',
			'length' => '10',
			'attribute' => '',
			'null' => '',
			'ai' => '1',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'country_code',
			'type' => 'char',
			'length' => '2',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
		[
			'name' => 'zone_name',
			'type' => 'varchar',
			'length' => '35',
			'attribute' => '',
			'null' => '',
			'ai' => '',
			'comment' => '',
			'enums' => [
			],
		],
	],
	'indexes' => [
		[
			'name' => '',
			'type' => 'primary',
			'fields' => [
				'zone_id',
			],
		],
		[
			'name' => 'idx_zone_name',
			'type' => 'index',
			'fields' => [
				'zone_name',
			],
		],
	],
];




?>