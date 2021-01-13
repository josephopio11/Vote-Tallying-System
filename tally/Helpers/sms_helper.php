<?php

if (!function_exists('sendPanelSms'))
{
    /**
     * You Need to put here your sms sending function
     */
    function sendPanelSms($smsData, $config = [])
    {
        sleep(3);

        $smsto = $smsData['smsto'];
        $message = $smsData['message'];

        $smsData['is_sended'] = 1;
                
        return $smsData;
    }

}


if (!function_exists('saveSmsHistory'))
{

    function saveSmsHistory($historyData)
    {
        if (empty($historyData))
        {
            return false;
        }
        
        $Sms_historyModel = new \Tally\Models\C4_sms_historyModel();

        return $Sms_historyModel->save($historyData);
    }

}
