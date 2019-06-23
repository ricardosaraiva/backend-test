import React, { Component } from 'react';
import NavDefault from './route/NavDefault';
import NavLoged from './route/NavLoged';
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
      return <NavLoged  user={this.state.user} />;
    }
    
    return <NavDefault />
  }

  render() {
    return (
      <div id="wrapper">
        {this.renderNav()}
      </div>
    );
  }
}