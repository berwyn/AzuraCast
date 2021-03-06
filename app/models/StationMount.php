<?php
namespace Entity;

use AzuraCast\Radio\Frontend\FrontendAbstract;

/**
 * @Table(name="station_mounts")
 * @Entity(repositoryClass="Entity\Repository\StationMountRepository")
 * @HasLifecycleCallbacks
 */
class StationMount
{
    /**
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     * @var int
     */
    protected $id;

    /**
     * @Column(name="station_id", type="integer")
     * @var int
     */
    protected $station_id;

    /**
     * @ManyToOne(targetEntity="Station", inversedBy="mounts")
     * @JoinColumns({
     *   @JoinColumn(name="station_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     * @var Station
     */
    protected $station;

    /**
     * @Column(name="name", type="string", length=100)
     * @var string
     */
    protected $name;

    /**
     * @Column(name="is_default", type="boolean")
     * @var bool
     */
    protected $is_default;

    /**
     * @Column(name="is_public", type="boolean")
     * @var bool
     */
    protected $is_public;

    /**
     * @Column(name="fallback_mount", type="string", length=100, nullable=true)
     * @var string|null
     */
    protected $fallback_mount;

    /**
     * @Column(name="relay_url", type="string", length=255, nullable=true)
     * @var string|null
     */
    protected $relay_url;

    /**
     * @Column(name="authhash", type="string", length=255, nullable=true)
     * @var string|null
     */
    protected $authhash;

    /**
     * @Column(name="enable_autodj", type="boolean")
     * @var bool
     */
    protected $enable_autodj;

    /**
     * @Column(name="autodj_format", type="string", length=10, nullable=true)
     * @var string|null
     */
    protected $autodj_format;

    /**
     * @Column(name="autodj_bitrate", type="smallint", nullable=true)
     * @var int|null
     */
    protected $autodj_bitrate;

    /**
     * @Column(name="frontend_config", type="text", nullable=true)
     * @var string|null
     */
    protected $frontend_config;

    public function __construct(Station $station)
    {
        $this->station = $station;

        $this->name = '';
        $this->is_default = false;
        $this->is_public = false;
        $this->enable_autodj = true;

        $this->autodj_format = 'mp3';
        $this->autodj_bitrate = 128;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Station
     */
    public function getStation(): Station
    {
        return $this->station;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Ensure all mountpoint names start with a leading slash.
     * @param $new_name
     */
    public function setName(string $new_name)
    {
        $this->name = '/' . ltrim($new_name, '/');
    }

    /**
     * @return bool
     */
    public function getIsDefault(): bool
    {
        return $this->is_default;
    }

    /**
     * @param bool $is_default
     */
    public function setIsDefault(bool $is_default)
    {
        $this->is_default = $is_default;
    }

    /**
     * @return bool
     */
    public function getIsPublic(): bool
    {
        return $this->is_public;
    }

    /**
     * @param bool $is_public
     */
    public function setIsPublic(bool $is_public)
    {
        $this->is_public = $is_public;
    }

    /**
     * @return null|string
     */
    public function getFallbackMount(): ?string
    {
        return $this->fallback_mount;
    }

    /**
     * @param null|string $fallback_mount
     */
    public function setFallbackMount($fallback_mount)
    {
        $this->fallback_mount = $fallback_mount;
    }

    /**
     * @return mixed
     */
    public function getRelayUrl()
    {
        return $this->relay_url;
    }

    /**
     * @param null|string $relay_url
     */
    public function setRelayUrl($relay_url)
    {
        $this->relay_url = $relay_url;
    }

    /**
     * @return string|null
     */
    public function getAuthhash(): ?string
    {
        return $this->authhash;
    }

    /**
     * @param null|string $authhash
     */
    public function setAuthhash(string $authhash = null)
    {
        $this->authhash = $authhash;
    }

    /**
     * @return bool
     */
    public function getEnableAutodj(): bool
    {
        return $this->enable_autodj;
    }

    /**
     * @param bool $enable_autodj
     */
    public function setEnableAutodj(bool $enable_autodj)
    {
        $this->enable_autodj = $enable_autodj;
    }

    /**
     * @return null|string
     */
    public function getAutodjFormat(): ?string
    {
        return $this->autodj_format;
    }

    /**
     * @param null|string $autodj_format
     */
    public function setAutodjFormat(string $autodj_format = null)
    {
        $this->autodj_format = $autodj_format;
    }

    /**
     * @return int|null
     */
    public function getAutodjBitrate(): ?int
    {
        return $this->autodj_bitrate;
    }

    /**
     * @param int|null $autodj_bitrate
     */
    public function setAutodjBitrate(int $autodj_bitrate = null)
    {
        $this->autodj_bitrate = $autodj_bitrate;
    }

    /**
     * @return string|null
     */
    public function getFrontendConfig(): ?string
    {
        return $this->frontend_config;
    }

    /**
     * @param null|string $frontend_config
     */
    public function setFrontendConfig(string $frontend_config = null)
    {
        $this->frontend_config = $frontend_config;
    }

    /**
     * Retrieve the API version of the object/array.
     *
     * @param FrontendAbstract $fa
     * @return Api\StationMount
     */
    public function api(FrontendAbstract $fa): Api\StationMount
    {
        $response = new Api\StationMount;

        $response->name = (string)$this->name;
        $response->is_default = (bool)$this->is_default;
        $response->url = (string)$fa->getUrlForMount($this->name);

        if ($this->enable_autodj) {
            $response->bitrate = (int)$this->autodj_bitrate;
            $response->format = (string)$this->autodj_format;
        }

        return $response;
    }
}