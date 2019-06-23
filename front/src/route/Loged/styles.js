import styled from 'styled-components';

const Container = styled.ul`
  background: var(--primary-color);  
`;

const BrandContainer =  styled.a``;

const BrandIconContainer = styled.div``;

const BrandIcon = styled.i``;

const BrandText = styled.span``;

const UserName = styled.div`
  color: #FFF;
  font-size: 12px;
  margin: 5px;
`;

const Divider = styled.hr`
    border-top: 1px solid rgba(255,255,255,.15);
    margin: 2px;
`;

const NavItem = styled.li`
    display: block;
    height: 40px;
`;

const NavItemLink = styled.a``;

const NavItemLinkIcon = styled.i``;

const NavItemLinkText = styled.span``;

const ButtonLogout = styled.button`
  margin: 10px
`;

Container.defaultProps = {
  className: 'navbar-nav bg-gradient-primary sidebar sidebar-dark accordion'
};

BrandContainer.defaultProps = {
  className: 'sidebar-brand d-flex align-items-center justify-content-center'
};

BrandIconContainer.defaultProps = {
  className: 'sidebar-brand-icon'
};

BrandIcon.defaultProps = {
  className: 'fas fa-user'
};

BrandText.defaultProps = {
  className: 'sidebar-brand-text mx-3'
};

NavItem.defaultProps = {
  className: 'nav-item'
};

NavItemLink.defaultProps = {
  className: 'nav-link'
};

ButtonLogout.defaultProps = {
  className: 'btn btn-danger'
}

export {
  Container,
  BrandContainer,
  BrandIconContainer,
  BrandIcon,
  BrandText,
  UserName,
  Divider,
  NavItem,
  NavItemLink,
  NavItemLinkIcon,
  NavItemLinkText, 
  ButtonLogout
};