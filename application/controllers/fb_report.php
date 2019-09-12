<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fb_Report extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('fb_report_model');

        if ($this->session->userdata('person_id') == NULL) {
            redirect("/login", "refresh");
        }
    }

    public function index() {
        $this->load->view('fb_common/header');
        $this->load->view('fb_report/home');
        $this->load->view('fb_common/footer');
    }

    function today_cash() {
        /* get order and payments */
        /* get all payments */
        $data['orders'] = $this->fb_report_model->get_order($this->session->userdata('branch_id'), date('Y-m-d'), date('Y-m-d'));
        $data['payments'] = $this->fb_report_model->get_payment($this->session->userdata('branch_id'), date('Y-m-d'), date('Y-m-d'));
        $data['expense'] = $this->fb_report_model->get_expense($this->session->userdata('branch_id'), date('Y-m-d'), date('Y-m-d'));
        $data['branch'] = $this->session->userdata('branch_id');
        $this->load->view('fb_common/header');
        $this->load->view('fb_report/overall_balance', $data);
        $this->load->view('fb_common/footer');
    }

    function order_report() {
        if ($this->input->post('branch_id', true) == '') {
            $this->session->set_userdata('message', 'Select a branch !');
            redirect('fb_report/');
        } else {
            $from_date = $this->input->post('from_year') . '-' . $this->input->post('from_month') . '-' . $this->input->post('from_day');
            $to_date = $this->input->post('to_year') . '-' . $this->input->post('to_month') . '-' . $this->input->post('to_day');
            $type = $this->input->post('type', true);
            $branch = $this->input->post('branch_id', true);
            $result = $this->fb_report_model->generate_order_report($from_date, $to_date, $type, $branch);

            $this->load->view('fb_common/header');
            $this->load->view('fb_report/view_order_report', array('result' => $result, 'from' => $from_date, 'to' => $to_date, 'type' => $type, 'branch' => $branch));
            $this->load->view('fb_common/footer');
        }
    }

    function branch_summary_report() {
        if ($this->input->post('branch_id', true) == '') {
            $this->session->set_userdata('message', 'Select a branch !');
            redirect('fb_report/');
        } else {
            $from_date = $this->input->post('from_year') . '-' . $this->input->post('from_month') . '-' . $this->input->post('from_day');
            $to_date = $this->input->post('to_year') . '-' . $this->input->post('to_month') . '-' . $this->input->post('to_day');
            $type = $this->input->post('type', true);
            $branch = $this->input->post('branch_id', true);


            $data['orders'] = $this->fb_report_model->get_order_branch($branch, $from_date, $to_date, $type);
            $data['payments'] = $this->fb_report_model->get_payment_branch($branch, $from_date, $to_date, $type);
            $data['expense'] = $this->fb_report_model->get_expense_branch($branch, $from_date, $to_date, $type);
            $data['branch'] = $branch;
            $data['datee'] = $from_date . ' - - ' . $to_date;
            $data['type'] = $type;
            $this->load->view('fb_common/header');
            $this->load->view('fb_report/branch_summary', $data);
            $this->load->view('fb_common/footer');
        }
    }

    function transfer_summary_report() {
        if ($this->input->post('from_branch_id', true) == '' || $this->input->post('to_branch_id', true) == '') {
            $this->session->set_userdata('message', 'Select  branch !');
            redirect('fb_report/');
        } else {
            $from_date = $this->input->post('from_year') . '-' . $this->input->post('from_month') . '-' . $this->input->post('from_day');
            $to_date = $this->input->post('to_year') . '-' . $this->input->post('to_month') . '-' . $this->input->post('to_day');
            $type = $this->input->post('type', true);
            $from_branch = $this->input->post('from_branch_id', true);
            $to_branch = $this->input->post('to_branch_id', true);

            $data['from_branch'] = $this->fb_report_model->get_branch_name($from_branch);
            $data['to_branch'] = $this->fb_report_model->get_branch_name($to_branch);
            $data['datee'] = $from_date . ' - - ' . $to_date;
            $data['type'] = $type;
            $data['results'] = $this->fb_report_model->get_tranfer_report($from_branch, $to_branch, $from_date, $to_date, $type);
            $this->load->view('fb_common/header');
            $this->load->view('fb_report/transfer_summary', $data);
            $this->load->view('fb_common/footer');
        }
    }

    function expense_report() {
        if ($this->input->post('branch_id', true) == '') {
            $this->session->set_userdata('message', 'Select a branch !');
            redirect('fb_report/');
        } else {
            $from_date = $this->input->post('from_year') . '-' . $this->input->post('from_month') . '-' . $this->input->post('from_day');
            $to_date = $this->input->post('to_year') . '-' . $this->input->post('to_month') . '-' . $this->input->post('to_day');
            $type = $this->input->post('type', true);
            $branch = $this->input->post('branch_id', true);
            $exp_type = $this->input->post('exp_type_id', true);

            $data['branch'] = $this->fb_report_model->get_branch_name($branch);
            $data['datee'] = $from_date . ' - - ' . $to_date;
            $data['type'] = $type;



            $data['results'] = $this->fb_report_model->get_expense_report($exp_type, $branch, $from_date, $to_date, $type);


            $this->load->view('fb_common/header');
            $this->load->view('fb_report/expense_summary', $data);
            $this->load->view('fb_common/footer');
        }
    }

    function attendance_report() {
        if ($this->input->post('branch_id', true) == '') {
            $this->session->set_userdata('message', 'Select a branch !');
            redirect('fb_report/');
        } else {
            $from_date = $this->input->post('from_year') . '-' . $this->input->post('from_month') . '-' . $this->input->post('from_day');
            $to_date = $this->input->post('to_year') . '-' . $this->input->post('to_month') . '-' . $this->input->post('to_day');
            $type = $this->input->post('type', true);
            $branch = $this->input->post('branch_id', true);
            $member = $this->input->post('member_id', true);

            $data['branch'] = $this->fb_report_model->get_branch_name($branch);
            $data['datee'] = $from_date . ' - - ' . $to_date;
            $data['type'] = $type;
            $data['results'] = $this->fb_report_model->get_attendance_report($member, $branch, $from_date, $to_date, $type);

            $this->load->view('fb_common/header');
            $this->load->view('fb_report/attendance', $data);
            $this->load->view('fb_common/footer');
        }
    }

    /* end of function */
}

?>
