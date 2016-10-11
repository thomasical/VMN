New features added
	• Multiselect
	• Tags
	• Replace humhub ‘signin’ button with ‘sign in with linked in’ button. 
	• Redirect to survey page after login.
	• Disable top menus
		o My space
		o Directory
		o Dashboard
		o Humhub search menu


Files edited to add multiselect functionality


	• HForms.php        (\protected\humhub\compat)
	• BaseType.php      (\protected\humhub\modules\user\models\fieldtype)
	• Edit.php          (\protected\humhub\modules\user\views\account)
	• editField.php     (\protected\humhub\modules\admin\views\user-profile)


Purpose for editing files


HForms.php

	• To enable multiselect field in view file. 
	• Functionality is enabled in account setting/edit profile page.
	• Functionality means displaying multi select and saving selected values to db.


BaseType.php

	• Core file to define the field types.
	• New field types are defined in this file


Edit.php

	• To add helper text for multi select
	• To style multiselect



editField.php  
    
	• To add helper text at new profile page creation page.
	• Helper text is added to option field for multi select



Files newly created for multiselect

	• MultiSelectDropdown.php     (\protected\humhub\modules\user\models\fieldtype)


Purpose

	• Define what is multiselect
	• Working of multiselect is defined in this file.


Files edited to add Tag functionality

	• HForms.php       (\protected\humhub\compat)
	• BaseType.php     (\protected\humhub\modules\user\models\fieldtype)
	• Edit.php         (\protected\humhub\modules\user\views\account)



Purpose for editing files


HForms.php

	• To enable Tag field in view file. 
	• Functionality is enabled in account setting/edit profile page.
	• Functionality means displaying multi select and saving selected values to db



BaseType.php

	• Core file to define the field types.
	• New field types are defined in this file




Edit.php

	• To style Tag field


Files newly created for multiselect

	• Tag.php              (\protected\humhub\modules\user\models\fieldtype)
	• TagAsset.php         (\protected\humhub\Assets)



Purpose


Tag.php

	• Define what is tag
	• Working of Tag is defined in this file.



TagAsset.php 
   
	• To enable asset for Tag



Other core files edited

	• accountTopMenu.php (\protected\humhub\modules\user\widgets\views)
		o Purpose : Replace humhub ‘signin’ button with ‘sign in with linked in’ button. 
	• 401_guest.php (\protected\humhub\views\error)
		o Purpose : Replace humhub ‘signin’ button with ‘sign in with linked in’ button.
	• UserController   (\protected\humhub\modules\admin\controllers)
		o Purpose :  To disable csrf validation
	• ModuleController.php  (\protected\humhub\modules\admin\controllers)
		o Purpose :  To disable csrf validation
	• ProfileController.php (\protected\humhub\modules\user\controllers)
		o Purpose :  To redirect to survey page after login.
	• Event.php (\protected\humhub\modules\search)
		o Purpose :  To disable search menu from top menu
	• Chooser.php (\protected\humhub\modules\space\widgets\views)
		o Purpose :  To disable Myspace menu from top menu
	• Module.php (\protected\humhub\modules\directory)
		o Purpose :  To disable Directory menu from top menu
	• Event.php (\protected\humhub\modules\dashboard)
		o Purpose :  To disable Dashboard menu from top menu


