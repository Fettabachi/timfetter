## Tim Fetter WordPress Portfolio Theme

## Installation

### Requirements

Requires the following dependencies:

- [Download and install Node.js and npm](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)

### Setup

```sh
$ npm install
```

### To Develop

```sh
$ npm run devFast
```

### To Build(Deploy)

```sh
$ npm run build
```

### Page Banner Demo Panel

The page-banner block is the main front-end feature in this theme. A separate
demo panel is included to showcase the banner's visual states and controls in
the browser without requiring a WordPress admin walkthrough.

- Core banner rendering lives in `blocks/page-banner/`.
- The demo harness lives in `parts/demo-panel.php`, `css/demo-panel.css`, and `src/demo-panel.js`.
- The demo panel is only loaded on front-end requests where the banner is relevant.
