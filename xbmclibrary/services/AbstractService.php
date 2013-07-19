<?php
abstract class AbstractService {
	public abstract function  get($param);
	public abstract function  post($param);
	public abstract function  put($param);
	public abstract function  delete($param);
}

?>