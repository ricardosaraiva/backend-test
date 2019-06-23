import React, { Component } from 'react';

import { 
    Container,
    BrandContainer,
    BrandIconContainer,
    BrandIcon, 
    BrandText, 
    Divider,
    NavItem,
    NavItemLink,
    NavItemLinkIcon,
    NavItemLinkText,
    ButtonLogout,
    UserName
} 
from './styles';

export default class Nav extends Component {

    state = {
        menus: [
            {label: 'Event', icon: 'calendar', url: '#'},
            {label: 'User', icon: 'user', url: '#'}
        ]
    }

    render() {
        return <Container id="accordionSidebar">
            
            <BrandContainer href="#">
                <BrandIconContainer>
                    <BrandIcon></BrandIcon>
                </BrandIconContainer>

                <BrandText>
                    Event Network
                </BrandText>
            </BrandContainer>

            <UserName>
                <b>User:</b>  {this.props.user.name}
            </UserName>

            <Divider />

            {
                this.state.menus.map((menu, i) => (
                    <NavItem key={i}>
                        <NavItemLink href={menu.url}>
                            <NavItemLinkIcon className={`fas fa-fw fa-${menu.icon}`} />
                            <NavItemLinkText>{menu.label}</NavItemLinkText>
                        </NavItemLink>
                    </NavItem>
                ))
            }

            <Divider />

            <ButtonLogout>Logout</ButtonLogout>
        </Container>;
    }
}
