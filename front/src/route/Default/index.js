import React, { Component, Fragment } from 'react';
import Nav from './Nav';
import Route from './Route';

export default class Default extends Component {
  render() {
    return <Fragment>
      <Nav />
      <Route />
    </Fragment>;
  }
}
