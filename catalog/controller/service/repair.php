<?php
class ControllerServiceRepair extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('operation/sell');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['text_your_details'] = "Enter following details";

		$data['problems'] = [
			[
				'key' => 'network_issue',
				'value' => 'Network problem'
			],
			[
				'key' => 'charging_issue',
				'value' => 'Not charging'
			],
			[
				'key' => 'broken_screen',
				'value' => 'Broken screen'
			],
			[
				'key' => 'sound_problem',
				'value' => 'Sound/Speaker not working'
			],
			[
				'key' => 'mic_issue',
				'value' => 'Mic not working on calls'
			]
		];

		$this->load->model('catalog/category');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('service/repair', $data));
		
	}

}
