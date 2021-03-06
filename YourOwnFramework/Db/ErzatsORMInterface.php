<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace YourOwnFramework\Db;

/**
 * Interface ErzatsORMInterface
 * @package YourOwnFramework\Db
 *
 * ________________________________¶¶¶¶¶¶¶
 * _______________________________¶¶¶_____¶¶¶¶
 * _____________________________¶¶¶__________¶¶
 * ___________________________¶¶______¶_______¶¶
 * _____________¶¶¶¶¶___¶¶¶¶¶¶_________¶______¶¶
 * _____________¶_¶__¶¶¶¶___¶¶¶¶¶¶¶¶____¶_____¶¶
 * _____________¶__¶¶__¶__________¶¶¶¶¶_¶_____¶¶
 * ____________¶¶___¶¶_¶¶_____________¶¶¶¶_____¶
 * ____________¶¶____¶¶__¶¶¶¶¶__________¶¶_____¶
 * _____________¶¶__¶¶________¶¶_________¶______¶
 * ______________¶¶_____________¶¶¶_______¶_____¶
 * ___________¶¶¶¶________________¶¶¶¶¶___¶¶____¶¶
 * ___________¶¶¶_____¶¶¶¶¶______¶¶¶¶¶¶¶___¶¶___¶¶
 * ____¶¶_____¶¶____¶¶_¶¶¶¶¶____¶_¶¶¶_¶¶¶¶__¶¶__¶
 * ____¶¶¶¶¶__¶¶¶___¶¶_¶¶¶__¶___¶_¶¶¶_¶¶_¶¶¶¶¶¶¶¶
 * ____¶___¶¶___¶¶____¶¶¶¶¶______¶¶¶¶¶_____¶¶¶¶_¶¶¶
 * ____¶_____¶___¶¶_________¶¶¶¶__________¶_¶_____¶¶
 * ___¶¶_____¶¶___¶¶_____¶___¶¶___¶_____¶¶__¶_____¶¶
 * ___¶¶______¶_____¶¶¶¶__¶¶¶¶¶¶¶¶___¶¶¶¶____¶¶_¶¶¶
 * ____¶______¶________¶¶¶_________¶¶¶________¶¶¶¶
 * _____¶_____¶¶_________¶¶¶¶¶¶¶¶¶¶
 * ______¶¶_____¶¶¶_¶¶¶¶¶__¶___¶__¶¶
 * _______¶¶¶_____¶¶¶_______¶¶¶____¶
 * _________¶¶¶¶¶¶_________________¶¶
 * ______________¶¶_____________¶_¶¶
 * ______________¶______¶¶¶____¶_¶¶
 * ______________¶¶_____¶¶¶___¶¶_¶
 * _______________¶¶____¶_¶¶__¶¶¶_¶
 * ________________¶_____¶¶____¶_¶¶¶
 * ________________¶¶¶¶_¶¶¶¶¶_¶¶¶¶¶
 * ___________________¶¶¶___¶¶¶

 */
interface ErzatsORMInterface
{
    public function load(array $params = []);

    public function getParams();

    public function getPrimaryKey();

    public function getUtilFields();

    public function delete();

    public function save();
}