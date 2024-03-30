<?php defined('BASEPATH') or exit('No direct script access allowed');
class Backlog extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public $data = [];
    public $ion_auth;
    public function index()
    {
        if ($this->ion_auth->logged_in()) {
            $this->data['page_title'] = 'Backlog - ' . company_name();
            $this->data['main_page'] = 'Backlog';
            $this->data['current_user'] = $this->ion_auth->user()->row();
            $this->db->where('saas_id', $this->session->userdata('saas_id'));
            $query = $this->db->get('sprints');
            $sprints = $query->result_array();
            foreach ($sprints as &$sprint) {
                if (!$sprint["starting_date"] && !$sprint["ending_date"] && $sprint["duration"]) {
                    $current = new DateTime($sprint["created"]);
                    $sprint["starting_date"] =  $current->format('d M Y');
                    if ($sprint["duration"] == 1) {
                        $current = new DateTime($sprint["created"]);
                        $current->modify('+1 week');
                        $sprint["ending_date"] = $current->format('d M Y');
                    }
                }
            }
            $this->db->select('*');
            $this->db->from('task_status');
            $query7 = $this->db->get();
            $this->data['task_statuses'] = $query7->result_array();

            $this->data["sprints"] = $sprints;
            $this->db->select('*');
            $this->db->from('issues');
            $this->db->where_in('saas_id', $this->session->userdata());
            $query = $this->db->get();
            $issues = $query->result_array();

            foreach ($issues as &$issue) {
                $id = $issue["id"];
                $this->db->select('*');
                $this->db->where('issue_id', $id);
                $query5 = $this->db->get('issues_users');
                $row5 = $query5->row();
                $issue["issue_user"] = '10';
                $this->db->select('*');
                $this->db->where('issue_id', $id);
                $query = $this->db->get('issues_sprint');
                $row = $query->row();
                if ($row) {
                    $issue["sprint_id"] = $row->sprint_id;
                    $this->db->select('*');
                    $this->db->where('id', $row->sprint_id);
                    $query2 = $this->db->get('sprints');
                    $row2 = $query2->row();
                    $issue["sprint_title"] = $row2->title;
                    $issue["starting_date"] = $row2->starting_date;
                    $issue["ending_date"] = $row2->ending_date;
                    $issue["starting_time"] = $row2->starting_time;
                    $issue["ending_time"] = $row2->ending_time;
                    $issue["duration"] = $row2->duration;
                    $issue["user"] = $row5->user_id;
                }
            }

            $this->data['issues'] = $issues;
            if ($this->ion_auth->is_admin() || permissions('project_view_all')) {
                $this->data['system_users'] = $this->ion_auth->members()->result();
            } elseif (permissions('project_view_selected')) {
                $selected = selected_users();
                foreach ($selected as $user_id) {
                    $users[] = $this->ion_auth->user($user_id)->row();
                }
                $users[] = $this->ion_auth->user($this->session->userdata('user_id'))->row();
                $this->data['system_users'] = $users;
            }
            $this->load->view('backlog', $this->data);
        } else {
            redirect('auth', 'refresh');
        }
    }
    public function start_sprint($id = '')
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin() || permissions('plan_holiday_view'))) {
            if (empty($id)) {
                $id = $this->uri->segment(3) ? $this->uri->segment(3) : '';
            }
            $data = [
                'status'=>1
            ];
            if (!empty($id) && is_numeric($id) && $this->board_model->status_change_sprint($id, $data)) {
                $this->data['error'] = false;
                $this->data['message'] = $this->lang->line('started_successfully') ? $this->lang->line('started_successfully') : "Started successfully.";
                echo json_encode($this->data);
            } else {
                $this->data['error'] = true;
                $this->data['message'] = $this->lang->line('something_wrong_try_again') ? $this->lang->line('something_wrong_try_again') : "Something wrong! Try again.";
                echo json_encode($this->data);
            }
        } else {
            $this->data['error'] = true;
            $this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
            echo json_encode($this->data);
        }
    }
    public function complete_sprint($id = '')
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin() || permissions('plan_holiday_view'))) {
            if (empty($id)) {
                $id = $this->uri->segment(3) ? $this->uri->segment(3) : '';
            }
            $data = [
                'status'=>2
            ];
            if (!empty($id) && is_numeric($id) && $this->board_model->status_change_sprint($id, $data)) {
                $this->data['error'] = false;
                $this->data['message'] = $this->lang->line('started_successfully') ? $this->lang->line('started_successfully') : "Started successfully.";
                echo json_encode($this->data);
            } else {
                $this->data['error'] = true;
                $this->data['message'] = $this->lang->line('something_wrong_try_again') ? $this->lang->line('something_wrong_try_again') : "Something wrong! Try again.";
                echo json_encode($this->data);
            }
        } else {
            $this->data['error'] = true;
            $this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
            echo json_encode($this->data);
        }
    }
    public function delete_sprint($id = '')
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin())) {
            if (empty($id)) {
                $id = $this->uri->segment(3) ? $this->uri->segment(3) : '';
            }
            if (!empty($id) && is_numeric($id) && $this->board_model->delete_sprint($id)) {
                $this->data['error'] = false;
                $this->data['message'] = $this->lang->line('started_successfully') ? $this->lang->line('started_successfully') : "Started successfully.";
                echo json_encode($this->data);
            } else {
                $this->data['error'] = true;
                $this->data['message'] = $this->lang->line('something_wrong_try_again') ? $this->lang->line('something_wrong_try_again') : "Something wrong! Try again.";
                echo json_encode($this->data);
            }
        } else {
            $this->data['error'] = true;
            $this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
            echo json_encode($this->data);
        }
    }
    public function get_sprint_by_id($id = '')
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin() || permissions('plan_holiday_view'))) {
            if (empty($id)) {
                $id = $this->uri->segment(3) ? $this->uri->segment(3) : '';
            }
            if (!empty($id) && is_numeric($id)) {
                $sprint = $this->board_model->get_sprint_by_id($id);
                $this->data['sprint'] = $sprint;
                $this->data['error'] = false;
                $this->data['message'] = $this->lang->line('started_successfully') ? $this->lang->line('started_successfully') : "Started successfully.";
                echo json_encode($this->data);
            } else {
                $this->data['error'] = true;
                $this->data['message'] = $this->lang->line('something_wrong_try_again') ? $this->lang->line('something_wrong_try_again') : "Something wrong! Try again.";
                echo json_encode($this->data);
            }
        } else {
            $this->data['error'] = true;
            $this->data['message'] = $this->lang->line('access_denied') ? $this->lang->line('access_denied') : "Access Denied";
            echo json_encode($this->data);
        }
    }
}