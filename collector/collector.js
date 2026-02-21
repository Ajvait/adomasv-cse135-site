(function () {
  'use strict';

  const ENDPOINT = 'https://collector.adomasvcse135.site/collect.php';

  function getSessionId() {
    let sid = sessionStorage.getItem('_collector_sid');
    if (!sid) {
      sid = Math.random().toString(36).substring(2) + Date.now().toString(36);
      sessionStorage.setItem('_collector_sid', sid);
    }
    return sid;
  }

  function getNetworkInfo() {
    if (!('connection' in navigator)) return {};

    const conn = navigator.connection;
    return {
      effectiveType: conn.effectiveType || '',
      downlink: conn.downlink || 0,
      rtt: conn.rtt || 0,
      saveData: conn.saveData || false
    };
  }

  function getTechnographics() {
    return {
      userAgent: navigator.userAgent,
      language: navigator.language,
      cookiesEnabled: navigator.cookieEnabled,
      viewportWidth: window.innerWidth,
      viewportHeight: window.innerHeight,
      screenWidth: window.screen.width,
      screenHeight: window.screen.height,
      pixelRatio: window.devicePixelRatio,
      cores: navigator.hardwareConcurrency || 0,
      memory: navigator.deviceMemory || 0,
      network: getNetworkInfo(),
      colorScheme: window.matchMedia('(prefers-color-scheme: dark)').matches
        ? 'dark' : 'light',
      timezone: Intl.DateTimeFormat().resolvedOptions().timeZone
    };
  }

  function getPerformanceData() {
    const nav = performance.getEntriesByType('navigation')[0];
    if (!nav) return {};

    return {
      startTime: nav.startTime,
      domContentLoaded: nav.domContentLoadedEventEnd,
      loadEventEnd: nav.loadEventEnd,
      totalLoadTime: nav.loadEventEnd - nav.startTime,
      fullTimingObject: nav.toJSON()
    };
  }

  function sendEvent(data) {
    const payload = {
      ...data,
      session: getSessionId(),
      url: window.location.href,
      timestamp: new Date().toISOString()
    };

    const blob = new Blob([JSON.stringify(payload)], {
      type: 'application/json'
    });

    if (navigator.sendBeacon) {
      navigator.sendBeacon(ENDPOINT, blob);
    } else {
      fetch(ENDPOINT, {
        method: 'POST',
        body: blob,
        keepalive: true
      });
    }
  }

  function sendPageview() {
    sendEvent({
      type: 'pageview',
      title: document.title,
      referrer: document.referrer,
      technographics: getTechnographics(),
      performance: getPerformanceData()
    });
  }

  document.addEventListener('mousemove', function (e) {
    sendEvent({
      type: 'mousemove',
      x: e.clientX,
      y: e.clientY
    });
  });

  document.addEventListener('click', function (e) {
    sendEvent({
      type: 'click',
      button: e.button,
      x: e.clientX,
      y: e.clientY
    });
  });

  document.addEventListener('scroll', function () {
    sendEvent({
      type: 'scroll',
      scrollX: window.scrollX,
      scrollY: window.scrollY
    });
  });

  document.addEventListener('keydown', function (e) {
    sendEvent({
      type: 'keydown',
      key: e.key
    });
  });

  window.onerror = function (message, source, lineno, colno) {
    sendEvent({
      type: 'error',
      message,
      source,
      lineno,
      colno
    });
  };

  let lastActivity = Date.now();
  let idleStart = null;

  function resetIdleTimer() {
    const now = Date.now();

    if (idleStart) {
      sendEvent({
        type: 'idle_end',
        duration: now - idleStart
      });
      idleStart = null;
    }

    lastActivity = now;
  }

  setInterval(function () {
    if (!idleStart && Date.now() - lastActivity >= 2000) {
      idleStart = Date.now();
    }
  }, 500);

  ['mousemove', 'keydown', 'click', 'scroll']
    .forEach(event =>
      document.addEventListener(event, resetIdleTimer)
    );

  window.addEventListener('load', function () {
    sendEvent({ type: 'enter_page' });
    sendPageview();
  });

  document.addEventListener('visibilitychange', function () {
    if (document.visibilityState === 'hidden') {
      sendEvent({ type: 'leave_page' });
    }
  });

})();