import React, { Component } from 'react';
import {BrowserRouter, Switch, Route} from 'react-router-dom';
import List from '../../page/Event/List';

export default class Routes extends Component {
  render() {
    return (
        <BrowserRouter>
            <Switch>
                <Route path="/" component={List} />
            </Switch>
        </BrowserRouter>
    );
  }
}
