<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Responders;
use Illuminate\Http\Request;


use App\Library\activecampaign\ActiveCampaign;
use App\Library\sendlane\Sendlane;
use App\Library\mailchimp\Mailchimp;
use App\Library\campaignmoniter\Campaignmoniter;
use App\Library\convertkit\ConvertKitApi;
use App\Library\icontact\iContactApi;
use App\Library\getdrip\GetDrip;
use App\Library\sendinblue\Sendinblue;
use MailerLiteApi\MailerLite;

class RespondersController extends Controller
{
    public function __construct()
    {
        addVendors(['global-dashboard-assets']);
    }

    public function index()
    {
        addVendors(['auto-responders']);
        $Responders = Responders::latest()->get();
        return view('dashboard.auto-responders', ['title' => 'Auto Responders', 'nameTitileImg' => $this->nameTitileImg(), 'InputFields' => $this->inputFields(), 'ActiveResponders' => $Responders]);
    }

    public function respondersGetInput(Request $request)
    {
        $inputArray = $this->InputFields();
        foreach ($inputArray as $key => $value) {
            if ($key == $request->key) {
                $matches[] = $value;
            }
        }

        $Responders = Responders::where('key', $request->key)->latest()->first();

        if (!empty($Responders)) {
            $data = array_values(json_decode($Responders->data, true));
            echo '<input type="hidden" name="id" id="id" value="' . $Responders->id . '">';
        }

        echo '<input type="hidden" name="title" value="' . $request->title . '">';
        echo '<input type="hidden" name="keyInput" value="' . $request->key . '">';


        $x = 0;
        foreach ($matches[0] as $key => $val) {
            if (empty($data)) {
                echo '<div class="col-md-3">
                                <label for="first-name-horizontal">' . $val . '</label>
                            </div>
                        <div class="col-md-9 form-group">
                            <input type="text" class="form-control" name="' . $key . '">
                        </div>';
            } else {
                echo '<div class="col-md-3">
                            <label for="first-name-horizontal">' . $val . '</label>
                        </div>
                    <div class="col-md-9 form-group">
                        <input type="text" class="form-control" value="' . $data[$x] . '" name="' . $key . '">
                    </div>';
            }
            $x++;
        }
    }

    public function RespondersConfigSave(Request $request)
    {
        $input = $request->all();
        unset($input['id']);
        unset($input['_token']);
        unset($input['title']);
        unset($input['keyInput']);
        $array_keys = array_keys($input);
        // dd($array_keys);
        $validate = $request->validate(array_fill_keys($array_keys,'required'));
        $res = Responders::updateOrCreate(
            [
                'id'   => $request->id ?? '',
            ],
            [
                'set'     => 'no',
                'title'     => $request->title,
                'key'     => $request->keyInput,
                'data'     => json_encode($input),
            ]
        );

        // ResponderDefaultSet
        $count = Responders::get()->count();
        if ($count == 1) {
            Responders::where('id', $res->id)->update([
                'set' => 'yes',
            ]);
        }
        return response()->json(['status' => 200, 'msg' => 'Successfully saved']);
    }


    public function defaultSet(Request $request)
    {

        if (empty($request->id)) {
            return response()->json(['status' => 'error', 'msg' => 'please select option']);
        }

        Responders::where('set', 'yes')->update([
            'set' => 'no',
        ]);

        Responders::where('id', $request->id)->update([
            'set' => 'yes',
        ]);

        $res = Responders::find($request->id);

        $options = $this->DataResponder($res->key);

        return response()->json(['status' => 'success', 'msg' => 'Default set has been updated', 'html' => $options, 'id' => $res->id]);
    }

    public function apiGet($responder_key)
    {
        $Responders = Responders::where('key', $responder_key)->first();
        return $api = json_decode($Responders->data, true);
    }

    public function DataResponder($responder_key)
    {

        $campaign_list = '';
        $responder = $responder_key;
        $api = $this->apiGet($responder);


        if ($responder == 'activecampaign') {
            $acobj = new ActiveCampaign();
            $campaign_list = $acobj->getActiveCampaignLists($api['api_access_url'], $api['api_access_key']);
        }

        if ($responder == 'sendlane') {
            $Sendlane = new Sendlane();
            $campaign_list = $Sendlane->getSendlaneLists($api['api_key']);
        }

        if ($responder == 'mailchimp') {
            $mailchimp = new Mailchimp($api['api_key']);
            $retval = $mailchimp->lists();
            $campaign_list = $retval['data'];
        }

        if ($responder == 'campaignmonitor') {
            $campaignmoniter = new Campaignmoniter($api['api_key']);
            $campaign_list = $campaignmoniter->getCampaignmoniterLists($api['api_client_id'], $api["api_key"]);
        }

        if ($responder == 'convertkit') {
            $convertkit = new ConvertKitApi();
            $campaign_list = $convertkit->getConvertKitForms($api['api_key']);
        }

        if ($responder == 'icontact') {
            iContactApi::getInstance()->setConfig(array(
                'appId' => $api['api_id'],
                'apiPassword' => $api['app_password'],
                'apiUsername' => $api['user_name'],
            ));
            $iContactApi = iContactApi::getInstance();
            $retval = $iContactApi->getLists();
            $campaign_list = $retval;
        }

        if ($responder == 'getdrip') {
            $GetDrip = new GetDrip();
            $campaign_list = $GetDrip->getGetDripLists($api['api_token'], $api['account_id']);
        }

        if ($responder == 'sendinblue') {
            $sendinblue = new Sendinblue();
            $campaign_list = $sendinblue->getSendinblueLists($api["api_key"]);
        }

        if ($responder == 'mailerlite') {
            $mailerliteClient = new MailerLite($api["api_key"]);
            $groupsApi = $mailerliteClient->groups();
            $campaign_list = $groupsApi->get(); // returns array of groups
        }




        $html = '';
        if ($campaign_list) {
            if ($responder == 'activecampaign') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->id . '">' . $list->name . '</option>';
                endforeach;
            } elseif ($responder == 'sendlane') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->id . '">' . $list->name . '</option>';
                endforeach;
            } elseif ($responder == 'mailchimp') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list['id'] . '">' . $list['name'] . '</option>';
                endforeach;
            } elseif ($responder == 'getresponse') {
                foreach ($campaign_list as $key => $list) :
                    if (@$list->name) :
                        $html .= '<option value="' . $list->campaignId . '">' . $list->name . '</option>';
                    endif;
                endforeach;
            } elseif ($responder == 'campaignmonitor') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->ListID . '">' . $list->Name . '</option>';
                endforeach;
            } elseif ($responder == 'convertkit') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->id . '">' . $list->name . '</option>';
                endforeach;
            } elseif ($responder == 'constantcontact') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list['list_id'] . '">' . $list['name'] . '</option>';
                endforeach;
            } elseif ($responder == 'icontact') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->listId . '">' . $list->name . '</option>';
                endforeach;
            } elseif ($responder == 'mailwizzema') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list['general']['list_uid'] . '">' . $list['general']['name'] . '</option>';
                endforeach;
            } elseif ($responder == 'getdrip') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list . '">' . $list . '</option>';
                endforeach;
            } elseif ($responder == 'mailerlite') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->id . '">' . $list->name . '</option>';
                endforeach;
            } elseif ($responder == 'mautic') {
                foreach ($campaign_list as $id => $list) :
                    $html .= '<option value="' . $list['id'] . '">' . $list['name'] . '</option>';
                endforeach;
            } elseif ($responder == 'sendinblue') {
                foreach ($campaign_list as $list) :
                    $html .= '<option value="' . $list->id . '">' . $list->name . '</option>';
                endforeach;
            }
        }

        return $html;
    }

    public function SetCampaignID(Request $request)
    {
        Responders::where('id', $request->ResponderID)->update([
            'campaign_id' => $request->CampaignID,
        ]);
    }

    public function nameTitileImg()
    {
        return array(
            array(
                'title'    => 'Active Campaign',
                'icon'    => asset('responders/activeCampaign.png'),
                'key'    => 'activecampaign'
            ),
            array(
                'title'    => 'Sendlane',
                'icon'    => asset('responders/sendlane.png'),
                'key'    =>  'sendlane'
            ),
            array(
                'title'    => 'MailChimp',
                'icon'    => asset('responders/mailchimp.png'),
                'key'    => 'mailchimp'
            ),
            // array(
            //     'title'    => 'GetResponse',
            //     'icon'    => asset('responders/getresponse.png'),
            //     'key'    => 'getresponse'
            // ),
            array(
                'title'    => 'Campaign Monitor',
                'icon'    => asset('responders/campaignmonitor.png'),
                'key'    => 'campaignmonitor'
            ),
            array(
                'title'    => 'ConvertKit',
                'icon'    => asset('responders/convertkit.png'),
                'key'    => 'convertkit'
            ),
            // array(
            //     'title'    => 'ConstantContact',
            //     'icon'    => asset('responders/constant-contact.png'),
            //     'key'    => 'constantcontact'
            // ),
            array(
                'title'    => 'iContact',
                'icon'    => asset('responders/icontact.png'),
                'key'    => 'icontact'
            ),
            // array(
            //     'title'    => 'MailWizz EMA',
            //     'icon'    => asset('responders/mailwizz.png'),
            //     'key'    => 'mailwizzema'
            // ),
            // array(
            //     'title'    => 'Get Drip',
            //     'icon'    => asset('responders/getdrip.png'),
            //     'key'    => 'getdrip'
            // ),
            array(
                'title'    => 'Mailerlite',
                'icon'    => asset('responders/mailerlite.png'),
                'key'    => 'mailerlite'
            ),
            // array(
            //     'title'    => 'Mautic',
            //     'icon'    => asset('responders/mautic.png'),
            //     'key'    => 'mautic'
            // ),
            array(
                'title'    => 'SendinBlue',
                'icon'    => asset('responders/sendinblue.png'),
                'key'    => 'sendinblue'
            ),
        );
    }


    public function InputFields()
    {
        return array(
            'activecampaign' => array(
                'api_access_url' => 'API Access URL',
                'api_access_key' => 'API Access Key'
            ),
            'sendlane' => array(
                'api_key' => 'API Key'
            ),
            'mailchimp' => array(
                'api_key' => 'API Key'
            ),
            // 'getresponse' => array(
            //     'api_key' => 'API Key'
            // ),
            'campaignmonitor' => array(
                'api_key'         => 'API Key',
                'api_client_id' => 'API Client Id'
            ),
            'convertkit' => array(
                'api_key'         => 'API Key',
                'api_secret'     => 'API Secret'
            ),
            // 'constantcontact' => array(
            //     'api_key'         => 'API Key',
            //     'secret_key'     => 'Secret Key'
            // ),
            'icontact' => array(
                'api_id'         => 'API Id',
                'user_name'     => 'User Name',
                'app_password'     => 'App Password'
            ),
            // 'mailwizzema' => array(
            //     'api_url'         => 'API URL',
            //     'public_key'     => 'Public Key'
            // ),
            // 'getdrip' => array(
            //     'api_token'        => 'API Token',
            //     'account_id'    => 'Account Id'
            // ),
            'mailerlite' => array(
                'api_key'    => 'API Key'
            ),
            // 'mautic' => array(
            //     'base_url'        => 'Base URL',
            //     'public_key'    => 'Public Key',
            //     'secret_key'    => 'Secret Key'
            // ),
            'sendinblue' => array(
                'api_key'    => 'API Key'
            )
        );
    }
}
