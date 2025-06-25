<?php

namespace App\Tests\integration;

use App\Service\ShopwareAdminApi\Authenticator;
use App\Service\ShopwareAdminApi\CustomHttpClientInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

class AuthenticatorTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testWithBearerAuthenticationNotInCache(): void
    {
        $expectedToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhZG1pbmlzdHJhdGlvbiIsImp0aSI6ImM2YWY3NDQ4Yzc2MzZjMWE1NmVhOTM4ZDU4ODFjMWI4YmZlZDdhNDU1MWU4ODE4YTMxNjRmZmNhMWE5NGUxNzJkZDA1YWE5MTNiNTJiMWYyIiwiaWF0IjoxNzUwODM3OTk4Ljk2MjkxNSwibmJmIjoxNzUwODM3OTk4Ljk2MjkxNywiZXhwIjoxNzUwODM4NTk4Ljk0Mzk3OSwic3ViIjoiMDE5NzdlNmE1MjdjNzE5ZWE3ZGE2ODU0NjRjOWUyNjUiLCJzY29wZXMiOlsid3JpdGUiLCJhZG1pbiJdfQ.HsfdlBTrxeSbEiQclv0TsSFMw2un4QxwJ1P2HvSKTe4';
        $username = 'test';
        $password = 'test';

        $httpClientMock = $this->createConfiguredMock(CustomHttpClientInterface::class, [
            'sendPlainRequest' => '{"token_type":"Bearer","expires_in":600,"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhZG1pbmlzdHJhdGlvbiIsImp0aSI6ImM2YWY3NDQ4Yzc2MzZjMWE1NmVhOTM4ZDU4ODFjMWI4YmZlZDdhNDU1MWU4ODE4YTMxNjRmZmNhMWE5NGUxNzJkZDA1YWE5MTNiNTJiMWYyIiwiaWF0IjoxNzUwODM3OTk4Ljk2MjkxNSwibmJmIjoxNzUwODM3OTk4Ljk2MjkxNywiZXhwIjoxNzUwODM4NTk4Ljk0Mzk3OSwic3ViIjoiMDE5NzdlNmE1MjdjNzE5ZWE3ZGE2ODU0NjRjOWUyNjUiLCJzY29wZXMiOlsid3JpdGUiLCJhZG1pbiJdfQ.HsfdlBTrxeSbEiQclv0TsSFMw2un4QxwJ1P2HvSKTe4","refresh_token":"def50200882908dc8719a4956392318d39df447e1dc635fbaafd0e95f217ea52942490e11e2d206fc0b1faa3164330b2332e555b646ed199930e91f4adef5b495c42bb9b46eddd6b90309ab87f201bb83c7a3b38d8a8eed819a688f491efcda0a827ce4353ca5331c590ac5b01b868b8d57bb2e1140372f068d555956643a68aacf700108b592d87cb5700452cfb81b51a0ea08a926e2f83f2b93fef769c035313da408d07d174ac19b7004b4b1bf1a43e4e071a1d69e9c82381904b2b393e1cf146edbdee24a79a992956dd3516d48e548e7b27c09074e9b7985c6a029206d4b7e59c21908ba617008f5dd5604dba7cecc2c4d38b1bef6d846062b4ae76821cdc0e6654c97ff78860eca6953579eb7a4ede5a3cfab30a74403ce7ede80dc0b81d9a2e27049c2b7b2c00d82074c60dab0c36ae83da5de80279762cbec2ec5029e59759caec1aefebf09f706cc90a5bc00feb9529ea99184a0eb8808310ca6da7a6ff5d12759f461a75f997e6073703751fdc3c16f66abd0414f1fa2e16bfe895ce8ce77d84be5aa7e0c0725fae6d3d9ed7b322ebb35cffd925b923e73909"}'
        ]);

        $httpClientMock->expects($this->once())
            ->method('setBearerToken')
            ->with($this->equalTo($expectedToken));

        $arrayCache = new ArrayAdapter(0);

        $authenticator = new Authenticator(
            $username,
            $password,
            $httpClientMock,
            $arrayCache);

        $authenticator->withBearerAuthentication();

        $hashedCacheKey = hash('sha256',$username.$password);
        $cacheItem = $arrayCache->getItem($hashedCacheKey);

        $this->assertTrue($cacheItem->isHit());
        $this->assertEquals($expectedToken, $cacheItem->get());
    }

    /**
     * @return void
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function testWithBearerAuthenticationInCache(): void
    {
        $expectedToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhZG1pbmlzdHJhdGlvbiIsImp0aSI6ImM2YWY3NDQ4Yzc2MzZjMWE1NmVhOTM4ZDU4ODFjMWI4YmZlZDdhNDU1MWU4ODE4YTMxNjRmZmNhMWE5NGUxNzJkZDA1YWE5MTNiNTJiMWYyIiwiaWF0IjoxNzUwODM3OTk4Ljk2MjkxNSwibmJmIjoxNzUwODM3OTk4Ljk2MjkxNywiZXhwIjoxNzUwODM4NTk4Ljk0Mzk3OSwic3ViIjoiMDE5NzdlNmE1MjdjNzE5ZWE3ZGE2ODU0NjRjOWUyNjUiLCJzY29wZXMiOlsid3JpdGUiLCJhZG1pbiJdfQ.HsfdlBTrxeSbEiQclv0TsSFMw2un4QxwJ1P2HvSKTe4';
        $username = 'test';
        $password = 'test';


        $httpClientMock = $this->createConfiguredMock(CustomHttpClientInterface::class, [
            'sendPlainRequest' => '{"token_type":"Bearer","expires_in":600,"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhZG1pbmlzdHJhdGlvbiIsImp0aSI6ImM2YWY3NDQ4Yzc2MzZjMWE1NmVhOTM4ZDU4ODFjMWI4YmZlZDdhNDU1MWU4ODE4YTMxNjRmZmNhMWE5NGUxNzJkZDA1YWE5MTNiNTJiMWYyIiwiaWF0IjoxNzUwODM3OTk4Ljk2MjkxNSwibmJmIjoxNzUwODM3OTk4Ljk2MjkxNywiZXhwIjoxNzUwODM4NTk4Ljk0Mzk3OSwic3ViIjoiMDE5NzdlNmE1MjdjNzE5ZWE3ZGE2ODU0NjRjOWUyNjUiLCJzY29wZXMiOlsid3JpdGUiLCJhZG1pbiJdfQ.HsfdlBTrxeSbEiQclv0TsSFMw2un4QxwJ1P2HvSKTe4","refresh_token":"def50200882908dc8719a4956392318d39df447e1dc635fbaafd0e95f217ea52942490e11e2d206fc0b1faa3164330b2332e555b646ed199930e91f4adef5b495c42bb9b46eddd6b90309ab87f201bb83c7a3b38d8a8eed819a688f491efcda0a827ce4353ca5331c590ac5b01b868b8d57bb2e1140372f068d555956643a68aacf700108b592d87cb5700452cfb81b51a0ea08a926e2f83f2b93fef769c035313da408d07d174ac19b7004b4b1bf1a43e4e071a1d69e9c82381904b2b393e1cf146edbdee24a79a992956dd3516d48e548e7b27c09074e9b7985c6a029206d4b7e59c21908ba617008f5dd5604dba7cecc2c4d38b1bef6d846062b4ae76821cdc0e6654c97ff78860eca6953579eb7a4ede5a3cfab30a74403ce7ede80dc0b81d9a2e27049c2b7b2c00d82074c60dab0c36ae83da5de80279762cbec2ec5029e59759caec1aefebf09f706cc90a5bc00feb9529ea99184a0eb8808310ca6da7a6ff5d12759f461a75f997e6073703751fdc3c16f66abd0414f1fa2e16bfe895ce8ce77d84be5aa7e0c0725fae6d3d9ed7b322ebb35cffd925b923e73909"}'
        ]);

        $httpClientMock->expects($this->once())
            ->method('setBearerToken')
            ->with($this->equalTo($expectedToken));
        $httpClientMock->expects($this->never())
            ->method('sendPlainRequest');

        $arrayCache = new ArrayAdapter(0);
        $hashedCacheKey = hash('sha256',$username.$password);
        $cacheItem = $arrayCache->getItem($hashedCacheKey);
        $cacheItem->set($expectedToken);
        $arrayCache->save($cacheItem);

        $authenticator = new Authenticator(
            $username,
            $password,
            $httpClientMock,
            $arrayCache);

        $authenticator->withBearerAuthentication();
    }
}
