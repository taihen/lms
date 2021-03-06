<?php

/*
 * LMS version 1.11-git
 *
 *  (C) Copyright 2001-2019 LMS Developers
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 */

$this->BeginTrans();

$this->Execute("
	ALTER TABLE uiconfig ADD COLUMN userid integer DEFAULT NULL
		REFERENCES users (id) ON UPDATE CASCADE ON DELETE CASCADE;
	ALTER TABLE uiconfig ADD COLUMN configid integer DEFAULT NULL
		REFERENCES uiconfig (id) ON UPDATE CASCADE ON DELETE RESTRICT;
    ALTER TABLE uiconfig DROP CONSTRAINT IF EXISTS uiconfig_section_key;
    ALTER TABLE uiconfig DROP CONSTRAINT IF EXISTS uiconfig_section_var_key;
	ALTER TABLE uiconfig ADD CONSTRAINT uiconfig_section_key UNIQUE (section, var, userid);
");

$this->Execute("UPDATE dbinfo SET keyvalue = ? WHERE keytype = ?", array('2019080100', 'dbversion'));

$this->CommitTrans();
