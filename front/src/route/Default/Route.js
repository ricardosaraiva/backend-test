import React, { Component } from 'react';
import {BrowserRouter, Switch, Route} from 'react-router-dom';
import List from '../../page/Event/List';
import Detail from '../../page/Event/Detail';

export default class Routes extends Component {
  render() {
    return (
        <BrowserRouter>
            <Switch>
                <Route path="/" component={List} exact />
                <Route path="/event/:id/detail" component={Detail} />
            </Switch>
        </BrowserRouter>
    );
  }
}
