<?php
namespace app\components;

use yii\web\UrlRuleInterface;
use yii\base\BaseObject;

class NewsUrlRule extends BaseObject implements UrlRuleInterface
{
  // Job 1: Create pretty URLs from routes
  public function createUrl($manager, $route, $params)
  {
    // If someone wants to create a link to 'news/item-detail-new'
    if ($route === 'news/item-detail-new') {
      // And they provided a title parameter
      if (isset($params['title'])) {
        // Return the pretty URL: news/title (URL encoded)
        return 'news/' . urlencode($params['title']);
      }
    }

    // If this rule doesn't apply, return false
    return false;
  }

  // Job 2: Parse pretty URLs into routes
  public function parseRequest($manager, $request)
  {
    // Get the URL path (everything after the domain)
    $pathInfo = $request->getPathInfo();

    // Check if URL matches pattern: news/something
    if (preg_match('%^news/([^/]+)$%', $pathInfo, $matches)) {
      // Extract the title from the URL and decode it
      $title = urldecode($matches[1]);

      // Return the route and parameters
      return ['news/item-detail-new', ['title' => $title]];
    }

    // If this rule doesn't apply, return false
    return false;
  }
}
