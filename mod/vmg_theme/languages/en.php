<?php
return array(

	/**
	 * Menu items and titles
	 */

	'pages' => "Wiki",
	'pages:owner' => "%s's wikis",
	'pages:friends' => "Friends' wikis",
	'pages:all' => "All site wikis",
	'pages:add' => "Add a wiki",

	'pages:group' => "Group wikis",
	'groups:enablepages' => 'Enable group wikis',

	'pages:new' => "A new wiki",
	'pages:edit' => "Edit this wiki",
	'pages:delete' => "Delete this wiki",
	'pages:history' => "History",
	'pages:view' => "View wiki",
	'pages:revision' => "Revision",
	'pages:current_revision' => "Current Revision",
	'pages:revert' => "Revert",

	'pages:navigation' => "Navigation",

	'pages:notify:summary' => 'New wiki called %s',
	'pages:notify:subject' => "A new wiki: %s",
	'pages:notify:body' =>
'%s added a new wiki: %s

%s

View and comment on the page:
%s
',
	'item:object:page_top' => 'Top-level wikis',
	'item:object:page' => 'Wikis',
	'pages:nogroup' => 'This group does not have any wikis yet',
	'pages:more' => 'More wikis',
	'pages:none' => 'No wikis created yet',

	/**
	* River
	**/

	'river:create:object:page' => '%s created a wiki %s',
	'river:create:object:page_top' => '%s created a wiki %s',
	'river:update:object:page' => '%s updated a wiki %s',
	'river:update:object:page_top' => '%s updated a wiki %s',
	'river:comment:object:page' => '%s commented on a wiki titled %s',
	'river:comment:object:page_top' => '%s commented on a wiki titled %s',

	/**
	 * Form fields
	 */

	'pages:title' => 'Wiki title',
	'pages:description' => 'Wiki text',
	'pages:tags' => 'Tags',
	'pages:parent_guid' => 'Parent wiki',
	'pages:access_id' => 'Read access',
	'pages:write_access_id' => 'Write access',

	/**
	 * Status and error messages
	 */
	'pages:noaccess' => 'No access to wiki',
	'pages:cantedit' => 'You cannot edit this wiki',
	'pages:saved' => 'Wiki saved',
	'pages:notsaved' => 'Wiki could not be saved',
	'pages:error:no_title' => 'You must specify a title for this wiki.',
	'pages:delete:success' => 'The wiki was successfully deleted.',
	'pages:delete:failure' => 'The wiki could not be deleted.',
	'pages:revision:delete:success' => 'The wiki revision was successfully deleted.',
	'pages:revision:delete:failure' => 'The wiki revision could not be deleted.',
	'pages:revision:not_found' => 'Cannot find this revision.',

	/**
	 * Page
	 */
	'pages:strapline' => 'Last updated %s by %s',

	/**
	 * History
	 */
	'pages:revision:subtitle' => 'Revision created %s by %s',

	/**
	 * Widget
	 **/

	'pages:num' => 'Number of wikis to display',
	'pages:widget:description' => "This is a list of your wikis.",

	/**
	 * Submenu items
	 */
	'pages:label:view' => "View wiki",
	'pages:label:edit' => "Edit wiki",
	'pages:label:history' => "Wiki history",

	/**
	 * Sidebar items
	 */
	'pages:sidebar:this' => "This wiki",
	'pages:sidebar:children' => "Sub-wikis",
	'pages:sidebar:parent' => "Parent",

	'pages:newchild' => "Create a sub-wiki",
	'pages:backtoparent' => "Back to '%s'",
);
