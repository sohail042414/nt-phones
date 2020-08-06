<?php
class ControllerCommonSearch extends Controller {
	
	public function index() {
		$this->load->language('common/search');

		$data['text_search'] = $this->language->get('text_search');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		return $this->load->view('common/search', $data);
	}

	public function autocomplete() {
		$json = array();
		
		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['search'])) {

			$search = $this->request->get['search'];

			if(1==1){

				$filter_data = array(
					'filter_name'         => $search,
					// 'filter_tag'          => $tag,
					// 'filter_description'  => $description,
					// 'filter_category_id'  => $category_id,
					// 'filter_sub_category' => $sub_category,
					// 'sort'                => $sort,
					// 'order'               => $order,
					// 'start'               => ($page - 1) * $limit,
					// 'limit'               => $limit
				);

				//$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

				$results = $this->model_catalog_product->getProducts($filter_data);

				foreach ($results as $result) {
					
					if ($result['image']) {
						//$image = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
						$image = $this->model_tool_image->resize($result['image'], 60,40);
					} else {
						//$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
						$image = $this->model_tool_image->resize('placeholder.png', 60,40);
					}

					/*
					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = (int)$result['rating'];
					} else {
						$rating = false;
					}
					*/

					$json[] = array(
						'product_id'  => $result['product_id'],
						'img'       => $image,
						'name'        => $result['name'],
						'//description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
						//'price'       => $price,
						'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
					);
				}
			}

		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);
		/*
		$json = array(
			array(
				'manufacturer_id' => 8, 
				'name' => 'Testi2ng ab2c'
			),
			array(
				'manufacturer_id' => 3, 
				'name' => 'Test34ing ab34c'
			),
			array(
				'manufacturer_id' => 4, 
				'name' => 'Tes3ting ab2c'
			),
			array(
				'manufacturer_id' => 5, 
				'name' => 'Testing ab243c'
			),
			array(
				'manufacturer_id' => 7, 
				'name' => 'Testing a2342bc'
			),
			array(
				'manufacturer_id' => 8, 
				'name' => 'Testing ab2342c'
			),
			array(
				'manufacturer_id' => 9, 
				'name' => 'Testing ab234c'
			),

		);
		*/
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}