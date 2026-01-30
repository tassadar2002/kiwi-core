<?php


namespace Kiwi\Core\Service;


use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Kiwi\Core\Exception\AppException;

class FileService
{
	private string $disk;

	public function __construct()
	{
		$this->disk = config("kiwi.upload.disk") ?? "";
	}

	/**
	 * 设置存储引擎
	 * @param string $disk
	 */
	public function setDisk(string $disk): void
	{
		$this->disk = $disk;
	}

	/**
	 * 随机倒排索引目录
	 * @param string $dir 目标目录
	 * @return string
	 */
	public static function randomInvertedIndex(string $dir): string
	{
		$md5 = md5(uniqid());
		$section1 = substr($md5, 0, 2);
		$section2 = substr($md5, 2, 2);
		return "/$dir/$section1/$section2";
	}

	/**
	 * 获得文件保存路径
	 * @param string $fullName 源文件全路径
	 * @param string $ext 目标扩展名
	 * @param string $dir 目标目录
	 * @return string
	 */
	public function getStorePathByFullName(string $fullName, string $ext, string $dir): string
	{
		return $this->getStorePath(md5_file($fullName), $ext, $dir);
	}

	/**
	 * 获得文件保存路径
	 * @param string $content 源文件内容
	 * @param string $ext 目标扩展名
	 * @param string $dir 目标目录
	 * @return string
	 */
	public function getStorePathByContent(string $content, string $ext, string $dir): string
	{
		return $this->getStorePath(md5($content), $ext, $dir);
	}

	/**
	 * 转储文件
	 * @param string $url
	 * @param string $dir 目录名
	 * @return string
	 * @throws AppException
	 */
	public function dumpFile(string $url, string $dir): ?string
	{
		$content = $this->download($url);
		$path = Arr::get(parse_url($url), "path", "/");
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		return $this->upload($content, $ext, $dir);
	}

	/**
	 * 下载文件
	 * @param string $url
	 * @return string
	 * @throws AppException
	 */
	public function download(string $url): string
	{
		$client = new Client();
		try {
			$res = $client->get($url);
			if ($res->getStatusCode() !== 200) {
				throw new AppException("download fail {$url}");
			}
			return $res->getBody()->getContents();
		} catch (GuzzleException $e) {
			throw new AppException("download fail {$url}");
		}
	}

	/**
	 * 上传文件
	 * @param string $content 源文件内容
	 * @param string $ext 目标扩展名
	 * @param string $dir
	 * @param mixed $options
	 * @return string
	 * @throws AppException
	 */
	public function upload(string $content, string $ext, string $dir = "default", mixed $options = []): string
	{
		$storage = $this->disk($this->disk);
		$path = $this->getStorePathByContent($content, $ext, $dir);

		// exists, no upload
		if (!$storage->exists($path)) {
			$result = $storage->put($path, $content, $options);
			if ($result === false) {
				throw new AppException("upload fail");
			}
		}

		return $storage->url($path);
	}

	/**
	 * 上传文件
	 * @param string $fullName 源文件全路径
	 * @param string $ext 目标扩展名
	 * @param string $dir
	 * @param mixed $options
	 * @return string
	 * @throws AppException
	 */
	public function uploadByFullName(string $fullName, string $ext, string $dir = "default", mixed $options = []): string
	{
		$storage = $this->disk($this->disk);
		$path = $this->getStorePathByFullName($fullName, $ext, $dir);

		// exists, no upload
		if (!$storage->exists($path)) {
			$content = file_get_contents($fullName);
			$result = $storage->put($path, $content, $options);
			if ($result === false) {
				throw new AppException("upload oss fail");
			}
		}

		return $storage->url($path);
	}

	/**
	 * 获得文件保存路径
	 * @param string $md5
	 * @param string $ext
	 * @param string $dir
	 * @return string
	 */
	private function getStorePath(string $md5, string $ext, string $dir): string
	{
		$section1 = substr($md5, 0, 2);
		$section2 = substr($md5, 2, 2);
		$path = "/$dir/$section1/$section2/$md5";

		if (empty($ext)) {
			return $path;
		} else {
			return "$path.$ext";
		}
	}

	/**
	 * @param string $disk
	 * @return Filesystem
	 * @throws AppException
	 */
	private function disk(string $disk): Filesystem
	{
		try {
			return Storage::disk($disk);
		} catch (Exception $exception) {
			if (!array_key_exists($disk, config('filesystems.disks'))) {
				throw new AppException(
					"Disk [$disk] not configured, please add a disk config in `config/filesystems.php`.",
					500,
					$exception);
			}
			throw new AppException($exception->getMessage(), $exception->getCode(), $exception);
		}
	}
}