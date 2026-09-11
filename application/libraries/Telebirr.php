<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Telebirr receipt verification library.
 *
 * Fetches the Ethio Telecom transaction receipt page and parses
 * the transaction details so payments can be verified against it.
 */
class Telebirr
{
	private $base_url = 'https://transactioninfo.ethiotelecom.et/receipt/';
	private $timeout = 30;
	private $cacert_path;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->cacert_path = APPPATH . 'config' . DIRECTORY_SEPARATOR . 'cacert.pem';
	}

	/**
	 * Verify the given telebirr transaction/receipt number.
	 *
	 * @param string $tt_number  e.g. DI49G1UQE7
	 * @return array
	 */
	public function verify($tt_number)
	{
		$tt_number = strtoupper(trim($tt_number));

		$result = array(
			'found'             => false,
			'invoice_no'        => $tt_number,
			'status'            => '',
			'payment_date'      => '',
			'amount'            => '',
			'payer_name'        => '',
			'payer_phone'       => '',
			'credited_account'  => '',
			'is_today'          => false,
			'error'             => '',
		);

		if($tt_number === '') {
			$result['error'] = 'Enter the Telebirr transaction number first.';
			return $result;
		}

		// fetch the receipt page
		$html = $this->fetch($this->base_url . $tt_number);

		if($html === false || $html === '') {
			$result['error'] = 'Could not reach the Ethio Telecom verification service. Please try again.';
			return $result;
		}

		// invalid transaction number returns a short "request is not correct" page
		if(strlen($html) < 500 || strpos($html, 'not correct') !== false) {
			$result['error'] = 'Transaction not found. Please check the Telebirr transaction number.';
			return $result;
		}

		$result['found'] = true;

		// extract the 3-column data row containing invoice/date/amount
		$result['payment_date'] = $this->extract_data_row_field($html, 1);  // 2nd column = date
		$result['amount']        = $this->extract_data_row_field($html, 2);  // 3rd column = amount

		// extract simple 2-column label/value rows
		$result['status']           = $this->extract_label_value($html, 'transaction status');
		$result['payer_name']       = $this->extract_label_value($html, 'Payer Name');
		$result['payer_phone']      = $this->extract_label_value($html, 'Payer telebirr no');
		$result['credited_account'] = $this->extract_label_value($html, 'Credited party account no');

		// check that the payment was made today
		$result['is_today'] = $this->payment_is_today($result['payment_date']);

		return $result;
	}

	/**
	 * Extract a field from the 3-column data row that contains the invoice number.
	 * Column index: 0=invoice_no, 1=payment_date, 2=amount
	 *
	 * The receipt HTML contains a table with:
	 *   Header row: Invoice No. | Payment date | Settled Amount
	 *   Data row:   DI49G1UQE7  | DD-MM-YYYY HH:MM:SS | 20 Birr
	 *   Hidden row: twenty birr and zero cent (spelled-out amount, ignore this)
	 *
	 * Uses the invoice number (which equals the TT number) to locate the data row.
	 */
	private function extract_data_row_field($html, $column_index)
	{
		// find the row containing the invoice number / TT number as the first td
		// Match: <td ...> INVOICE </td> <td ...> DATE </td> <td ...> AMOUNT </td>
		// The amount td text ends with "Birr" in the real data row (not the hidden spelled-out row)
		if(preg_match(
			'/<tr[^>]*>\s*<td[^>]*>\s*[A-Z0-9]{7,}\s*<\/td>\s*<td[^>]*>\s*([\d-]+\s[\d:]+)\s*<\/td>\s*<td[^>]*>\s*(\d+\s*Birr)\s*<\/td>\s*<\/tr>/s',
			$html,
			$m
		)) {
			return trim($m[$column_index]);
		}

		// fallback: try without requiring the closing </tr>
		if(preg_match(
			'/<td[^>]*>\s*[A-Z0-9]{7,}\s*<\/td>\s*<td[^>]*>\s*([\d-]+\s[\d:]+)\s*<\/td>\s*<td[^>]*>\s*(\d+\s*Birr)/s',
			$html,
			$m
		)) {
			return trim($m[$column_index]);
		}

		return '';
	}

	/**
	 * Extract the value from a simple 2-column label/value row.
	 * Finds a <td> containing $needle, then the next sibling <td> is the value.
	 * Handles both properly closed and unclosed <td> tags.
	 */
	private function extract_label_value($html, $needle)
	{
		// match: <td ...> ... needle ... <td ...> VALUE </td>
		// The first td may or may not be closed
		$pattern = '/<td[^>]*>[^<]*' . preg_quote($needle, '/') . '[^<]*<\/td>\s*<td[^>]*>\s*(.*?)\s*<\/td>/si';

		if(preg_match($pattern, $html, $m)) {
			return trim(strip_tags($m[1]));
		}

		// fallback: first td not closed (unclosed <td> common in this receipt)
		$pattern2 = '/<td[^>]*>[^<]*' . preg_quote($needle, '/') . '[^<]*\s*<td[^>]*>\s*(.*?)\s*<\/td>/si';

		if(preg_match($pattern2, $html, $m)) {
			return trim(strip_tags($m[1]));
		}

		return '';
	}

	/**
	 * Fetch a URL via cURL with a browser user-agent.
	 */
	private function fetch($url)
	{
		$ch = curl_init();

		$options = array(
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => $this->timeout,
			CURLOPT_CONNECTTIMEOUT => $this->timeout,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_SSL_VERIFYPEER => true,
			CURLOPT_SSL_VERIFYHOST => 2,
			CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0 Safari/537.36',
			CURLOPT_HTTPHEADER     => array(
				'Accept: text/html,application/xhtml+xml',
				'Accept-Language: en-US,en;q=0.9,am;q=0.8',
			),
		);

		if(is_file($this->cacert_path)) {
			$options[CURLOPT_CAINFO] = $this->cacert_path;
		}

		curl_setopt_array($ch, $options);

		$html = curl_exec($ch);
		curl_close($ch);

		return $html;
	}

	/**
	 * Checks whether the payment date string is from today.
	 * The receipt date format is dd-mm-YYYY HH:MM:SS
	 */
	private function payment_is_today($payment_date)
	{
		if($payment_date === '') {
			return false;
		}

		if(preg_match('/(\d{2})-(\d{2})-(\d{4})/', $payment_date, $m)) {
			$day   = $m[1];
			$month = $m[2];
			$year  = $m[3];
			$date  = $year . '-' . $month . '-' . $day;
			$today = date('Y-m-d');
			return ($date === $today);
		}

		return false;
	}
}