//
//  SideMenuViewController.h
//  MFSideMenuDemo
//
//  Created by Michael Frederick on 3/19/12.

#import <UIKit/UIKit.h>
#import "MFSideMenu.h"
#import "WebViewController.h"

@class WebViewController;
@interface SideMenuViewController : UITableViewController<UISearchBarDelegate>
{
    NSMutableArray *array;
    WebViewController *webController;
}

@property (nonatomic, assign) MFSideMenu *sideMenu;

@end