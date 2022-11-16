<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 *  ==============================================================================
 *  Author      : Usman Sher
 *  Email       : uskhan099@Gmail.com
 *  For         : Repairer
 *  Web         : http://otsglobal.org
 *  ==============================================================================
 */

class Repairer
{

    public function __construct()
    {
        
    }

    public function __get($var)
    {
        return get_instance()->controller->$var;
    }

    private function _rglobRead($source, &$array = array())
    {
        if (!$source || trim($source) == "") {
            $source = ".";
        }
        foreach ((array) glob($source . "/*/") as $key => $value) {
            $this->_rglobRead(str_replace("//", "/", $value), $array);
        }
        $hidden_files = glob($source . ".*") and $htaccess = preg_grep('/\.htaccess$/', $hidden_files);
        $files = array_merge(glob($source . "*.*"), $htaccess);
        foreach ($files as $key => $value) {
            $array[] = str_replace("//", "/", $value);
        }
    }

    private function _zip($array, $part, $destination, $output_name = 'sma')
    {
        $zip = new ZipArchive;
        @mkdir($destination, 0777, true);

        if ($zip->open(str_replace("//", "/", "{$destination}/{$output_name}" . ($part ? '_p' . $part : '') . ".zip"), ZipArchive::CREATE)) {
            foreach ((array) $array as $key => $value) {
                $zip->addFile($value, str_replace(array("../", "./"), null, $value));
            }
            $zip->close();
        }
    }

    public function formatMoney($number)
    {
        $decimals = $this->mSettings->decimals;
        $ts = ',';
        $ds = '.';
        return ($this->mSettings->currency) .
        number_format($number);
    }

    public function formatQuantity($number, $decimals = '00')
    {
        if (!$decimals) {
            $decimals = $this->mSettings->qty_decimals;
        }
        return number_format($number, $decimals);
    }

    public function formatDecimal($number, $decimals = null)
    {
        $formatted = number_format($number, 2, '.', ',');
        return ($formatted);
    }


    public function formatDecimal2($number, $decimals = null)
    {
        $formatted = number_format($number, 2, '.', '');
        return ($formatted);
    }

    public function clear_tags($str)
    {
        return htmlentities(
            strip_tags($str,
                '<span><div><a><br><p><b><i><u><img><blockquote><small><ul><ol><li><hr><big><pre><code><strong><em><table><tr><td><th><tbody><thead><tfoot><h3><h4><h5><h6>'
            ),
            ENT_QUOTES | ENT_XHTML | ENT_HTML5,
            'UTF-8'
        );
    }

    public function decode_html($str)
    {
        return html_entity_decode($str, ENT_QUOTES | ENT_XHTML | ENT_HTML5, 'UTF-8');
    }

    public function roundMoney($num, $nearest = 0.05)
    {
        return round($num * (1 / $nearest)) * $nearest;
    }

    public function roundNumber($number, $toref = null)
    {
        switch ($toref) {
            case 1:
                $rn = round($number * 20) / 20;
                break;
            case 2:
                $rn = round($number * 2) / 2;
                break;
            case 3:
                $rn = round($number);
                break;
            case 4:
                $rn = ceil($number);
                break;
            default:
                $rn = $number;
        }
        return $rn;
    }

    public function unset_data($ud)
    {
        if ($this->session->userdata($ud)) {
            $this->session->unset_userdata($ud);
            return true;
        }
        return false;
    }

    public function hrsd($sdate)
    {
        if ($sdate) {
            return date('y-m-d', strtotime($sdate));
        } else {
            return '0000-00-00';
        }
    }

    public function hrld($ldate)
    {
        if ($ldate) {
            return date('y-m-d h:i:s', strtotime($ldate));
        } else {
            return '0000-00-00 00:00:00';
        }
    }

    public function fsd($inv_date)
    {
        if ($inv_date) {
            $jsd = 'y-m-d';
            if ($jsd == 'dd-mm-yyyy' || $jsd == 'dd/mm/yyyy' || $jsd == 'dd.mm.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 3, 2) . "-" . substr($inv_date, 0, 2);
            } elseif ($jsd == 'mm-dd-yyyy' || $jsd == 'mm/dd/yyyy' || $jsd == 'mm.dd.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 0, 2) . "-" . substr($inv_date, 3, 2);
            } else {
                $date = $inv_date;
            }
            return $date;
        } else {
            return '0000-00-00';
        }
    }

    public function fld($ldate)
    {
        if ($ldate) {
            $date = explode(' ', $ldate);
            $jsd = 'y-m-d h:i:s';
            $inv_date = $date[0];
            $time = $date[1];
            if ($jsd == 'dd-mm-yyyy' || $jsd == 'dd/mm/yyyy' || $jsd == 'dd.mm.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 3, 2) . "-" . substr($inv_date, 0, 2) . " " . $time;
            } elseif ($jsd == 'mm-dd-yyyy' || $jsd == 'mm/dd/yyyy' || $jsd == 'mm.dd.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 0, 2) . "-" . substr($inv_date, 3, 2) . " " . $time;
            } else {
                $date = $inv_date;
            }
            return $date;
        } else {
            return '0000-00-00 00:00:00';
        }
    }

    public function send_email($to, $subject, $message, $from = null, $from_name = null, $attachment = null, $cc = null, $bcc = null)
    {
        $this->load->library('email');
        $config['useragent'] = "Repairer by Open Technology Solutions";
        $config['protocol'] = 'smtp';
        $config['mailtype'] = "html";
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        // $this->load->library('encrypt');

        $config['smtp_host'] = $this->mSettings->smtp_host;
        $config['smtp_user'] = $this->mSettings->smtp_user;
        $config['smtp_pass'] = $this->mSettings->smtp_pass;
        $config['smtp_port'] = $this->mSettings->smtp_port;

        $this->email->initialize($config);

        if ($from && $from_name) {
            $this->email->from($from, $from_name);
        } elseif ($from) {
            $this->email->from($from, $this->mSettings->title);
        } else {
            $this->email->from($this->mSettings->invoice_mail, $this->mSettings->title);
        }

        $this->email->to($to);
        if ($cc) {
            $this->email->cc($cc);
        }
        if ($bcc) {
            $this->email->bcc($bcc);
        }
        $this->email->subject($subject);
        $this->email->message($message);
        if ($attachment) {
            if (is_array($attachment)) {
                foreach ($attachment as $file) {
                    $this->email->attach($file);
                }
            } else {
                $this->email->attach($attachment);
            }
        }

        if ($this->email->send()) {
            // echo $this->email->print_debugger(); die();
            return true;
        } else {
            // echo $this->email->print_debugger(); die();
            return false;
        }
    }
 
   
  
    public function imgto64($file_name){
        $bc = file_get_contents($file_name);
        $bcimage = base64_encode($bc);
        return $bcimage;
    }
  
    public function barcode($text = null, $bcs = 'code128', $height = 74, $stext = 1, $get_be = false, $re = false)
    {
        $drawText = ($stext != 1) ? false : true;
        $this->load->library('wf_barcode', '', 'bc');
        return $this->bc->generate($text, $bcs, $height, $drawText, $get_be, $re);
    }


    public function qrcode($type = 'text', $text = 'http://otsglobal.org', $size = 2, $level = 'H', $sq = null)
    {
        $file_name = 'assets/uploads/qrcode' . $this->session->userdata('user_id') . ($sq ? $sq : '') . ($this->mSettings->barcode_img ? '.png' : '.svg');
        if ($type == 'link') {
            $text = urldecode($text);
        }
        $this->load->library('wf_qrcode', '', 'qr');
        $config = array('data' => $text, 'size' => $size, 'level' => $level, 'savename' => $file_name);
        $this->qr->generate($config);
        $imagedata = file_get_contents($file_name);
        return "<img src='data:image/png;base64,".base64_encode($imagedata)."' alt='{$text}' class='qrimg' />";
    }
    public function generate_pdf($content, $name = 'download.pdf', $output_type = null, $footer = null, $margin_bottom = null, $header = null, $margin_top = null, $orientation = 'P')
    {

        $this->load->library('wf_mpdf', '', 'pdf');
        return $this->pdf->generate($content, $name, $output_type, $footer, $margin_bottom, $header, $margin_top, $orientation);
    }

    public function send_json($data)
    {
        header('Content-Type: application/json');
        die(json_encode($data));
        exit;
    }

    function slug($title, $type = NULL, $r = 1)
    {
        $this->load->helper('text');
        $slug = url_title(convert_accented_characters($title), '-', TRUE);
        $check_slug = $this->checkSlug($slug, $type);
        if (!empty($check_slug)) {
            $slug = $slug.$r; $r++;
            $this->slug($slug, $type, $r);
        }
        return $slug;
    }
    public function checkSlug($slug, $type = NULL) {
        return $this->db->get_where('categories', ['code' => $slug], 1)->row();
    }

    public function checkPermissions($action = null, $js = null, $module = null)
    {
        if (!$this->actionPermissions($action, $module)) {
            $this->session->set_flashdata('error', ("Access Denied! You don't have right to access the requested page. If you think it's by mistake, please contact administrator."));
            if ($js) {
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('panel')) . "'; }, 10);</script>");
            } else {
                redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'panel');
            }
        }
    }

    public function actionPermissions($action = null, $module = null)
    {

        if ($this->Admin) {
            // if ($this->Admin && stripos($action, 'delete') !== false) {
            //     return false;
            // }
            return true;
        } else {
            if (!$module) {
                $module = $this->mCtrler;
            }
            if (!$action) {
                $action = $this->mAction;
            }

            if ($this->Admin || $this->GP[$module . '-' . $action] == 1) {
                return true;
            } else {
                return false;
            }
        }

    }
    public function in_group($check_group)
    {
        if ( !$this->ion_auth->logged_in() ) {
            return false;
        }
        if (($this->ion_auth->get_users_groups()->row()->name) === $check_group) {
            return true;
        }
        return false;
    }



    public function paid_opts($paid_by = null, $purchase = false, $empty_opt = false, $reparation = FALSE)
    {
        $opts = '';
        if ($empty_opt) {
            $opts .= '<option value="">'.lang('select').'</option>';
        }
        $opts .= '
        <option value="cash"'.($paid_by && $paid_by == 'cash' ? ' selected="selected"' : '').'>'.lang("cash").'</option>';
        $opts .= '
        <option value="CC"'.($paid_by && $paid_by == 'CC' ? ' selected="selected"' : '').'>'.lang("CC").'</option>
        <option value="Cheque"'.($paid_by && $paid_by == 'Cheque' ? ' selected="selected"' : '').'>'.lang("cheque").'</option>
        <option value="other"'.($paid_by && $paid_by == 'other' ? ' selected="selected"' : '').'>'.lang("other").'</option>';
        return $opts;
    }

     public function md($page = FALSE)
    {
        die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . ($page ? site_url($page) : (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome')) . "'; }, 10);</script>");
    }

}
