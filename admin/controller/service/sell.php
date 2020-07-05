<?php
class ControllerServiceSell extends Controller {

	private $error = array();

	public function index() {
		$this->load->language('service/sell');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('service/sell_rate');

		$this->getList();
	}

	public function add() {

		$this->load->language('service/sell');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('service/sell_rate');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			

			$this->model_service_sell_rate->addSellRate($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('service/sell', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {

		$this->load->language('service/sell');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('service/sell_rate');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_service_sell_rate->editSellRate($this->request->get['repair_rate_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('service/sells', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {

		$this->load->language('service/sell');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('service/sell_rate');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $repair_rate_id) {
				$this->model_service_sell_rate->deleterate($repair_rate_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('service/sell', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}


	protected function getList() {

		if (isset($this->request->get['filter_title'])) {
			$filter_title = $this->request->get['filter_title'];
		} else {
			$filter_title = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('service/sell', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['add'] = $this->url->link('service/sell/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/rates/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['rates'] = array();

		$filter_data = array(
			'filter_title'	  => $filter_title,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		//$this->load->model('tool/image');

		$rate_total = $this->model_service_sell_rate->getTotalSellRates($filter_data);

		$results = $this->model_service_sell_rate->getSellRates($filter_data);

		$this->load->model('catalog/product');
		$this->load->model('service/issue');

		/*
		foreach ($results as $result) {

			$product_info = $this->model_catalog_product->getProduct($result['product_id']);

			$issue_info = $this->model_service_issue->getIssue($result['issue_id']);

			$data['repair_rates'][] = array(
				'repair_rate_id' => $result['repair_rate_id'],								
				'product_id' => $result['product_id'],
				'product_name' => $product_info['name'],
				'issue' => $issue_info['title'],
				'price' => $result['price'],							
				'edit'       => $this->url->link('service/sell/edit', 'user_token=' . $this->session->data['user_token'] . '&repair_rate_id=' . $result['repair_rate_id'] . $url, true)
			);
		}
		*/

		$this->load->model('catalog/product');

		$results = $this->model_catalog_product->getProducts();

		foreach ($results as $result) {

			$data['products'][] = array(
				'name' => $result['name'],
				'product_id' => $result['product_id'],
				'edit'       => $this->url->link('service/sell/edit', 'user_token=' . $this->session->data['user_token'] . '&product_id=' . $result['product_id'] . $url, true)
			);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
		}


		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_title'] = $this->url->link('service/sells', 'user_token=' . $this->session->data['user_token'] . '&sort=i.title' . $url, true);
		$url = '';

		/*
		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
		}
		*/


		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $rate_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('service/sells', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($rate_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($rate_total - $this->config->get('config_limit_admin'))) ? $rate_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $rate_total, ceil($rate_total / $this->config->get('config_limit_admin')));

		$data['filter_title'] = $filter_title;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('service/sell_rate_list', $data));
	}

	protected function getForm() {

		$data['text_form'] = !isset($this->request->get['product_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['product_id'])) {
			$data['error_product_id'] = $this->error['title'];
		} else {
			$data['error_product_id'] = array();
		}

		if (isset($this->error['prices'])) {
			$data['error_prices'] = $this->error['prices'];
		} else {
			$data['error_prices'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
		}


		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('service/sell', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['repair_rate_id'])) {
			$data['action'] = $this->url->link('service/sell/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('service/sell/edit', 'user_token=' . $this->session->data['user_token'] . '&repair_rate_id=' . $this->request->get['repair_rate_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('service/sell', 'user_token=' . $this->session->data['user_token'] . $url, true);


		$this->load->model('catalog/product');

		$product_info = array();
		
		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['product_id'])) {
			$data['product_id'] = $this->request->post['product_id'];
		} elseif (!empty($product_info)) {
			$data['product_id'] = $product_info['product_id'];
		} else {
			$data['product_id'] = '';
		}

		if (isset($this->request->post['prices'])) {
			$data['prices'] = $this->request->post['product_id'];
		} elseif (!empty($product_info)) {

			$prices = $this->model_service_sell_rate->getProductRates($product_info['product_id']);

			// echo '<pre>';
			// print_r($prices);
			// exit; 

			foreach($prices as $row){

				if($row['box'] == 1){
					$data['prices'][$row['grade_id']] = $row['price'];
				}else{
					$data['prices_without_box'][$row['grade_id']] = $row['price'];
				}
			}
			
			//$data['prices'] = array();
		} else {
			$data['prices'] = array();
		}


		
		$this->load->model('service/grade');
		$data['grades'] = $this->model_service_grade->getGrades();

		$data['products'] = $this->model_catalog_product->getProducts();


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('service/sell_form', $data));
	}

	protected function validateForm() {

		if (!$this->user->hasPermission('modify', 'service/sell')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((int) $this->request->post['product_id'] < 1) {
			$this->error['product_id'] = $this->language->get('error_product_id');
		}

		$prices = $this->request->post['prices'];

		foreach($prices as $val){

			if ((int) $val < 1) {
				$this->error['prices'] = $this->language->get('error_prices');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'service/sells')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'service/sell')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_title']) || isset($this->request->get['filter_model'])) {
			$this->load->model('service/sell');
			$this->load->model('catalog/option');

			if (isset($this->request->get['filter_title'])) {
				$filter_title = $this->request->get['filter_title'];
			} else {
				$filter_title = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_title'  => $filter_title,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);

				foreach ($product_options as $product_option) {
					$option_info = $this->model_catalog_option->getOption($product_option['option_id']);

					if ($option_info) {
						$product_option_value_data = array();

						foreach ($product_option['product_option_value'] as $product_option_value) {
							$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);

							if ($option_value_info) {
								$product_option_value_data[] = array(
									'product_option_value_id' => $product_option_value['product_option_value_id'],
									'option_value_id'         => $product_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $product_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'product_option_id'    => $product_option['product_option_id'],
							'product_option_value' => $product_option_value_data,
							'option_id'            => $product_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $product_option['value'],
							'required'             => $product_option['required']
						);
					}
				}

				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
