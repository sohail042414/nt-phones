<?php
class ControllerserviceSell extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('service/sell');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['action'] = '';

		$data['text_your_details'] = "Enter following details";

		$this->load->model('service/sell');

		$categories = $this->model_service_sell->getCategories();

		$this->load->model('tool/image');

		foreach($categories as $result){

			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
			}

			$data['description'] = html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8');

			$data['categories'][] = array(
				'name' => $result['name'],
				'image' => $image,
				'href' => ''
			);
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('service/sell', $data));
		
	}

}
