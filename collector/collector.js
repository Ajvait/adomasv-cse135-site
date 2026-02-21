// collector-v1.js — Minimal Analytics Beacon
(function() {
  'use strict';

  const endpoint = '/collect.php';

  function sendBeacon() {
  const payload = {
    url: window.location.href,
    title: document.title,
    referrer: document.referrer,
    timestamp: new Date().toISOString(),
    type: 'pageview'
  };

  const body = JSON.stringify(payload);

  if (navigator.sendBeacon) {
    navigator.sendBeacon(endpoint, body);
  } else {
    fetch(endpoint, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body,
      keepalive: true
    });
  }
}

  // Fire on page load
  if (document.readyState === 'complete') {
    sendBeacon();
  } else {
    window.addEventListener('load', sendBeacon);
  }
})();