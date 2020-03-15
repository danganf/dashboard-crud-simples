<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 22/01/19
 * Time: 10:19
 */
namespace App\MyClass;

class DependencyFiles extends \Danganf\MyClass\DependencyFiles
{
    const CSS_ICON_SELECT            = 'assets/css/iconselect.css';
    const CSS_MODAL_COINS_BANK_NOTES = 'assets/css/modal-banknotes-coins.css';
    const CSS_MENU_DROPDOWN_SELECT   = 'assets/css/menu-dropdown-select.css';
    const CSS_BOOT_SWITCH            = 'app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css';
    const CSS_SELECT_FULL            = 'app-assets/vendors/css/forms/selects/select2.min.css';
    const CSS_FORM_SWITCH            = 'app-assets/css/plugins/forms/switch.css';
    const CSS_TIMEDROPPER            = 'app-assets/vendors/css/extensions/timedropper.min.css';
    const CSS_DROPZONE               = 'app-assets/vendors/css/file-uploaders/dropzone.min.css';
    const CSS_DROPZONE_CONFIG        = 'app-assets/css/plugins/file-uploaders/dropzone.css';
    const CSS_ANIMATE                = 'app-assets/css/plugins/animate/animate.css';
    const CSS_TIMELINE               = 'app-assets/css/pages/timeline.css';
    const CSS_TOASTR_1               = 'app-assets/vendors/css/extensions/toastr.css';
    const CSS_TOASTR_2               = 'app-assets/css/plugins/extensions/toastr.css';
    const CSS_JQUERY_UI              = 'app-assets/vendors/css/ui/jquery-ui.min.css';
    const CSS_JQUERY_UI_2            = 'app-assets/css/plugins/ui/jqueryui.css';
    const CSS_SLIDE_PUSH_MENU        = 'app-assets/vendors/css/Blueprints/SlidePushMenus/css/component.css';

    const JS_SELECT_FULL             = 'app-assets/vendors/js/forms/select/select2.full.min.js';
    const JS_SELECT_HEIGHT           = 'app-assets/vendors/js/forms/select/maximize-select2-height.min.js';
    const JS_REPEATER                = 'app-assets/vendors/js/forms/repeater/jquery.repeater.min.js';
    const JS_BOOT_SWITCH             = 'app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js';
    const JS_BOOT_CHECKBOX           = 'app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js';
    const JS_TIMEDROPPER             = 'app-assets/vendors/js/extensions/timedropper.min.js';
    const JS_INPUT_MASK              = 'app-assets/vendors/js/forms/extended/inputmask/jquery.inputmask.bundle.min.js';
    const JS_FORMATTER               = 'app-assets/vendors/js/forms/extended/formatter/formatter.min.js';
    const JS_DROPZONE                = 'app-assets/vendors/js/extensions/dropzone.min.js';
    const JS_FORM_FIELD              = 'app-assets/vendors/js/forms/tags/form-field.js';
    const JS_JQUERY_UI               = 'app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js';
    const JS_TIMELINE_HORIZON        = 'assets/js/timeline/horizontal-timeline.js';
    const JS_TOASTR                  = 'app-assets/vendors/js/extensions/toastr.min.js';
    const JS_BUTTONS_SELECTS         = 'app-assets/js/scripts/ui/jquery-ui/buttons-selects.js';
    const jS_SLIDE_PUSH_MENU         = 'app-assets/vendors/js/Blueprints/SlidePushMenus/js/classie.js';
    const JS_MASK_MONEY              = 'assets/js/jquery.maskMoney.min.js';
    const JS_ICON_SELECT             = 'assets/js/iconselect.js';
    const JS_ICON_SCROLL             = 'assets/js/iscroll.js';
    const JS_MENU_DROPDOWN_SELECT    = 'assets/js/menu-dropdown-select.js';
    const JS_VENDOR_VALIDATE         = 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js';
    const JS_VENDOR_JQUERY_UI        = 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js';
    const JS_VENDOR_JFORM            = 'app-assets/vendors/js/forms/jquery.form.js';//'https://malsup.github.com/jquery.form.js';
    const JS_CRUD                    = 'assets/js/cruds/main.js';

    public function __construct($routeName)
    {
        $routeName = str_replace('_duplicate', '', $routeName);
        parent::__construct($routeName);
        //dd($this->routename);
        $this->loadDefault();
    }

    public function loadDefault(){

        if( substr( $this->routename, -5 ) === 'Index' || strpos( $this->routename, 'Index' ) !== FALSE ){
            $this->js[] = $this::JS_CRUD;
        }
    }

    public function routeCatalogProductsIndexInputs(){$this->routeCatalogProductsIndexMain();}
    public function routeCatalogProductsNewMain()    {$this->routeCatalogProductsViewMain();}
    public function routeCatalogProductsNewInputs()  {$this->routeCatalogProductsNewMain();}


    public function routeCatalogProductsIndexMain()  {
        $this->addBootstrapSwitch();
        $this->addSelect2();
        $this->css[] = '/app-assets/vendors/css/forms/toggle/switchery.min.css';
        $this->js[]  = $this::JS_CRUD;
        $this->js[]  = '/assets/js/printThis.js';
        $this->js[]  = '/app-assets/vendors/js/forms/toggle/switchery.min.js';
        $this->js[]  = '/app-assets/js/scripts/forms/switch.js';
    }

    public function routeCatalogProductsViewInputs(){
        $this->routeCatalogProductsViewMain();
    }

    public function routeCatalogProductsViewMain(){
        $this->addBootstrapSwitch();
        $this->addSelect2();
        $this->addJqueryUI();
        $this->addSlidePushMenu();
        $this->js[] = $this::JS_VENDOR_JFORM;
        $this->js[] = $this::JS_MASK_MONEY;
    }

    public function addDropZone(){
        $this->css[] = $this::CSS_DROPZONE;
        $this->css[] = $this::CSS_DROPZONE_CONFIG;
        $this->js[]  = $this::JS_DROPZONE;
    }

    private function addCatalogCategoriesNew(){
        $this->addBootstrapSwitch();
        $this->css[] = $this::CSS_ICON_SELECT;
        $this->js[]  = $this::JS_VENDOR_VALIDATE;
        $this->js[]  = $this::JS_ICON_SELECT;
        $this->js[]  = $this::JS_ICON_SCROLL;
    }
    private function addBootstrapSwitch(){
        $this->css[] = $this::CSS_BOOT_SWITCH;
        $this->css[] = $this::CSS_FORM_SWITCH;
        $this->js[]  = $this::JS_BOOT_SWITCH;
        $this->js[]  = $this::JS_BOOT_CHECKBOX;
    }
    private function addSlidePushMenu(){
        $this->css[] = $this::CSS_SLIDE_PUSH_MENU;
        $this->js[]  = $this::jS_SLIDE_PUSH_MENU;
    }
    private function addSelect2(){
        $this->css[] = $this::CSS_SELECT_FULL;
        $this->js[]  = $this::JS_SELECT_FULL;
        $this->js[]  = $this::JS_SELECT_HEIGHT;
    }
    private function addTimeDropper(){
        $this->css[] = $this::CSS_TIMEDROPPER;
        $this->js[]  = $this::JS_TIMEDROPPER;
    }
    private function addToastr(){
        $this->css[] = $this::CSS_TOASTR_1;
        $this->css[] = $this::CSS_TOASTR_2;
        $this->js[]  = $this::JS_TOASTR;
    }
    private function addFormRepeater(){
        $this->js[]  = $this::JS_REPEATER;
    }
    private function addCalendar(){
        $this->css[] = 'app-assets/vendors/css/calendars/fullcalendar.min.css';
        $this->css[] = 'app-assets/css/plugins/calendars/fullcalendar.css';
        $this->js[]  = 'app-assets/vendors/js/extensions/moment.min.js';
        $this->js[]  = 'app-assets/vendors/js/extensions/fullcalendar.min.js';
    }
    private function addTagging(){
        $this->css[] = 'app-assets/vendors/css/forms/tags/tagging.css';
        $this->js[]  = 'app-assets/vendors/js/forms/tags/tagging.min.js';
    }

    private function addMenuDropDownSelect(){
        $this->css[] = $this::CSS_MENU_DROPDOWN_SELECT;
        $this->js[]  = $this::JS_MENU_DROPDOWN_SELECT;
    }
    private function addJqueryUI(){
        $this->css[] = $this::CSS_JQUERY_UI;
        $this->css[] = $this::CSS_JQUERY_UI_2;
        $this->js[]  = $this::JS_JQUERY_UI;
        $this->js[]  = $this::JS_BUTTONS_SELECTS;
    }

}
