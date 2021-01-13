<?php

if (!function_exists('sendPanelEmail'))
{

    function sendPanelEmail($emailData, $config = [])
    {
        if(empty($emailData['mailto']))
        {
            return false;
        }

        $panelConfig = new \Agents\Config\Agents();
        $email = \Config\Services::email();

        $files       = $emailData['files'] ?? null;

        if (intval($emailData['trackEmail'] ?? NULL) === 1)
        {
            $emailData['cid'] = bin2hex(random_bytes(10));
            $tracking_image = agents_url("general/mopened/{$emailData['cid']}");
            $emailData['message'] .= "\n";
            $emailData['message'] .= '<img src="'. $tracking_image . '">';
        }
        else
        {
            $emailData['trackEmail'] = 0;
        }

        $config['charset']  = 'utf-8';
        $config['wordWrap'] = true;
        $config['mailType'] = 'html';

        $email->initialize($config);

        $fromEmail = $emailData['fromEmail'] ?? (!empty($email->fromEmail) ? $email->fromEmail : $panelConfig->fromEmail);
        $fromName  = $emailData['fromName'] ?? (!empty($email->fromName) ? $email->fromName : $panelConfig->panelTitle);

        $email->setFrom($fromEmail, $fromName);
        $email->setTo($emailData['mailto']);
        $email->setSubject($emailData['subject']  ?? 'No Subject');
        $email->setMessage($emailData['message']  ?? 'No message');


        if (!empty($files) && is_array($files))
        {
            $files = trim(implode(',', $files), ',');
            $emailData['files'] = trim($files, ',');    
        }
        else
        {
            $files = trim($files, ',');
            $emailData['files'] = $files;
        }

        if (!empty($files))
        {
            $fileService = \Agents\Config\Services::file();
            $fileDatas = $fileDatas = $fileService->getAllFile($files);

            if(!empty($fileDatas))
            {
                foreach ($fileDatas as $key => $fileData)
                {
                    if (!file_exists($fileData['reelpath']))
                    {
                        continue;
                    }

                    $email->attach($fileData['reelpath']);
                }
            }
        }

        if ($email->send(false))
        {
            $emailData['is_sended'] = 1;
        }
        else
        {
            $emailData['is_sended'] = 0;
            $emailData['debug']  = $email->printDebugger(['headers']);
        }
        
        return $emailData;
    }

}

if (!function_exists('sendEmailTemplate'))
{

    function sendEmailTemplate($templateName, $mailto,  $renderData = []) 
    {
        $parser = \Config\Services::parser();

        $templateData = getTemplateByName($templateName);

        if(empty($templateData))
        {
            return false;
        }

        $emailData['c4_template_id'] = $templateData['c4_template_id'];
        $emailData['files']       = $templateData['files'];
        $emailData['mailto']     = $mailto;
        $emailData['subject']     = $parser->setData($renderData)->renderString($templateData['title']);
        $emailData['message']     = $parser->setData($renderData)->renderString($templateData['content']);
            
        return sendPanelEmail($emailData);
   }

}

if (!function_exists('saveEmailHistory'))
{

    function saveEmailHistory($historyData)
    {
        if (empty($historyData))
        {
            return false;
        }
        
        $Email_historyModel = new \Agents\Models\C4_email_historyModel();

        return $Email_historyModel->save($historyData);
    }

}
 
if (!function_exists('sendOwnerMail'))
{
    function sendOwnerMail($message, $subject = null)
    {

        $panelConfig = new \Agents\Config\Agents();
        $emailData['mailto'] = $panelConfig->ownerEmail;

        if (!empty($subject))
        {
            $emailData['subject'] = $subject;
        }
        else
        {
            $emailData['subject'] = $panelConfig->panelTitle;
        }

        if (is_array($message) && !empty($message))
        {
        
            $emailData['message'] = '<pre>' . json_encode($message, JSON_PRETTY_PRINT) . '</pre>';

        }
        else
        {
            $emailData['message'] = (string) $message;
        }

        sendPanelEmail($emailData);
    }

}
