import React, { Component } from 'react';
import Default from './route/Default';
import Loged from './route/Loged';
import UserService from './service/UserService';

export default class App extends Component {

  state = {
    user: null
  }

  componentDidMount() {
    this.setState({user: UserService.getUser()});
  }

  renderNav() {
    if(this.state.user) {
      return <Loged  user={this.state.user} />;
    }
    
    return <Default />
  }

  render() {
    return (
      <div id="wrapper">
        {this.renderNav()}
      </div>
    );
  }
}