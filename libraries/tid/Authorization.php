<?php
/**
 * Trotri User Identity
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace tid;

/**
 * Authorization class file
 * 用户身份授权类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Authorization.php 1 2014-04-20 01:08:06Z huan.song $
 * @package tid
 * @since 1.0
 */
class Authorization
{
    /**
     * @var array 寄存所有的角色
     */
    protected $_roles = array();

    /**
     * 是否允许访问
     * @param string $appName
     * @param string $modName
     * @param string $ctrlName
     * @param integer $power
     * @return boolean
     */
    public function isAllowed($appName, $modName, $ctrlName, $power)
    {
        if ($this->_roles === array()) {
            return false;
        }

        foreach ($this->_roles as $role) {
            if ($role->isAllowed($appName, $modName, $ctrlName, $power)) {
                return true;
            }
        }

        return false;
    }

    /**
     * 是否拒绝访问
     * @param string $appName
     * @param string $modName
     * @param string $ctrlName
     * @param integer $power
     * @return boolean
     */
    public function isDenied($appName, $modName, $ctrlName, $power)
    {
        return !$this->isAllowed($appName, $modName, $ctrlName, $power);
    }

    /**
     * 获取一个角色
     * @param string $name
     * @return tid\Role
     */
    public function getRole($name)
    {
        if ($this->hasRole($name)) {
            return $this->_roles[$name];
        }

        return null;
    }

    /**
     * 添加一个角色，如果角色名已经存在，则替换老值
     * @param Role $role
     * @return tid\Authorization
     */
    public function addRole(Role $role)
    {
        $name = $role->getName();
        $this->_roles[$name] = $role;
        return $this;
    }

    /**
     * 删除一个角色
     * @param string $name
     * @return tid\Authorization
     */
    public function removeRole($name)
    {
        if ($this->hasRole($name)) {
            unset($this->_roles[$name]);
        }

        return $this;
    }

    /**
     * 判断角色是否存在
     * @param string $name
     * @return boolean
     */
    public function hasRole($name)
    {
        return isset($this->_roles[$name]);
    }

    /**
     * 获取所有的角色
     * @return array
     */
    public function getRoles()
    {
        return $this->_roles;
    }

    /**
     * 清空所有的角色
     * @return tid\Authorization
     */
    public function clearRoles()
    {
        $this->_roles = array();
        return $this;
    }

    /**
     * 删除所有的角色资源文件
     * @return boolean
     */
    public function flush()
    {
        $dir = $this->getDir();
        $fileNames = scandir($dir);
        if (is_array($fileNames)) {
            if (count($fileNames) === 2) {
                return true;
            }

            foreach ($fileNames as $fileName) {
                if ($fileName === '.' || $fileName === '..') {
                    continue;
                }

                $fileName = $dir . DS . $fileName;
                @unlink($fileName);
            }

            $fileNames = scandir($dir);
            if (count($fileNames) === 2) {
                return true;
            }
        }

        return false;
    }

    /**
     * 获取角色资源所在的目录名
     * @return string
     */
    public function getDir()
    {
        return DIR_DATA_RUNTIME_ROLES;
    }
}
